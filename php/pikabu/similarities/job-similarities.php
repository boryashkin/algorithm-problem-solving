<?php

interface FaceInterface {
    /**
     * Returns face id or 0, if face is new
     */
    public function getId(): int;
    /**
     * Returns race parameter: from 0 to 100.
     */
    public function getRace(): int;
    /**
     * Returns face emotion level: from 0 to 1000.
     */
    public function getEmotion(): int;
    /**
     * Returns face oldness level: from 0 to 1000.
     */
    public function getOldness(): int;
}
interface FaceFinderInterface {
    /**
     * Finds 5 most similar faces in DB.
     * If the specified face is new (id=0),
     * then it will be saved to DB.
     *
     * @param FaceInterface $face Face to find and save (if id=0)
     * @return FaceInterface[] List of 5 most similar faces,
     * including the searched one
     */
    public function resolve(FaceInterface $face): array;
    /**
     * Removes all faces in DB and (!) reset faces id sequence
     */
    public function flush(): void;
}

class Face implements FaceInterface
{
    public $l;//for debug

    private $id;
    private $race;
    private $emotion;
    private $oldness;

    public function __construct(int $race, int $emotion, int $oldness, int $id = 0)
    {
        $this->resetValues($race, $emotion, $oldness, $id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    /*
     * 0, 20, 40, 60, 80, 100 = 6
     */
    public function getRace(): int
    {
        return $this->race;
    }

    /*
     * 0, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000 = 11
     */
    public function getEmotion(): int
    {
        return $this->emotion;
    }

    /*
     * 0, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000 = 11
     */
    public function getOldness(): int
    {
        return $this->oldness;
    }

    /**
     * @param int $race
     * @param int $emotion
     * @param int $oldness
     * @param int $id
     */
    public function resetValues(int $race, int $emotion, int $oldness, int $id = 0): void
    {
        $this->race = $race;
        $this->emotion = $emotion;
        $this->oldness = $oldness;
        $this->id = $id;
    }
}

class FaceFinder implements FaceFinderInterface
{
    private const DB_NAME = 'face_finder';
    private const TABLE_NAME = 'faces';
    private const PRECOMPUTED_RACES = [0, 20, 40, 60, 80, 100];
    private const PRECOMPUTED_EMOTION = [0, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];
    private const PRECOMPUTED_OLDNESS = [0, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];

    /** @var PDO */
    private $connection;

    public function __construct(\PDO $connection = null)
    {
        if ($connection) {
            $this->connection = $connection;
        }
        if (!$this->prepareDb() || !$this->prepareTable()) {
            throw new \Exception('Db is not prepared');
        }
    }

    /** @inheritDoc */
    public function resolve(FaceInterface $face): array
    {
        $closestState = $this->getClosestPrecomputedState($face);
        if (!$face->getId()) {
            $result = $this->storeFace($face, $closestState);
            if ($result === false) {
                throw new \Exception('Failed to store a face');
            }
        }
        /** @var FaceInterface[] $resolvedFaces */
        $resolvedFaces = [];
        $resolvedLs = new SplMinHeap();
        if (!$closestFaces = $this->getClosestFacesId($closestState)) {
            throw new \Exception('No results for ' . $closestState);
        }
        foreach ($closestFaces as $face2) {
            $l = $this->getDistance($face, new Face((int)$face2->race, (int)$face2->emotion, (int)$face2->oldness));
            $resolvedLs->insert([$l, $face2->id]);
        }
        $values = [];
        while ($resolvedLs->count() > 0) {
            $value = $resolvedLs->extract();
            $values[$value[1]] = $value[0];
        }
        foreach ($closestFaces as $face2) {
            $resolvedFaces[$face2->id] = new Face((int)$face2->race, (int)$face2->emotion, (int)$face2->oldness, (int)$face2->id);
            $resolvedFaces[$face2->id]->l = $values[$face2->id];
        }
        $tmpRf = $resolvedFaces;
        $resolvedFaces = [];
        foreach ($values as $key => $value) {
            $resolvedFaces[] = $tmpRf[$key];
        }

        unset($resolvedLs);

        return \array_values($resolvedFaces);
    }

    /** @inheritDoc */
    public function flush(): void
    {
        $this->getConnection()->exec('TRUNCATE TABLE ' . self::TABLE_NAME);
    }

    /**
     * @param FaceInterface $face1
     * @param FaceInterface $face2
     * @return float
     */
    private function getDistance(FaceInterface $face1, FaceInterface $face2)
    {
        return \sqrt(
            ($face1->getRace() - $face2->getRace()) ** 2
            + ($face1->getEmotion() - $face2->getEmotion()) ** 2
            + ($face1->getOldness() - $face2->getOldness()) ** 2
        );
    }

    /**
     * @param FaceInterface $face
     * @return float|int
     */
    private function getClosestPrecomputedState(FaceInterface $face)
    {
        //Total number of states ~ 3276
        $closest = 4000;
        $minL = 99999;
        $i = 0;
        $comparedFace = new Face(0, 0, 0);
        foreach (self::PRECOMPUTED_RACES as $race) {
            foreach (self::PRECOMPUTED_EMOTION as $emotion) {
                foreach (self::PRECOMPUTED_OLDNESS as $oldness) {
                    $i++;
                    $comparedFace->resetValues($race, $emotion, $oldness);
                    $l = $this->getDistance($face, $comparedFace);
                    if ($l < $minL) {
                        $minL = $l;
                        $closest = $i;
                    }
                    if ($minL == 0) {
                        break 3;
                    }
                }
            }
        }

        return $closest;
    }

    /**
     * @param FaceInterface $face
     * @param int $closestState
     * @return bool
     */
    private function storeFace(FaceInterface $face, int $closestState)
    {
        $tableName = self::TABLE_NAME;

        $insertSql = <<<SQL
INSERT INTO $tableName (race, emotion, oldness, closest_state) VALUES (:race, :emotion, :oldness, :closest_state)
SQL;
        $stmt = $this->getConnection()->prepare($insertSql);
        $stmt->bindValue(':race', $face->getRace(), PDO::PARAM_INT);
        $stmt->bindValue(':emotion', $face->getEmotion(), PDO::PARAM_INT);
        $stmt->bindValue(':oldness', $face->getOldness(), PDO::PARAM_INT);
        $stmt->bindValue(':closest_state', $closestState, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * @param $closestState
     * @return bool|PDOStatement
     */
    private function getClosestFacesId($closestState)
    {
        $tableName = self::TABLE_NAME;
        $selectSql = <<<SQL
SELECT n.id, n.race, n.emotion, n.oldness, n.closest_state, ABS( cast(n.closest_state as signed) - :closestTo ) AS distance FROM (
	(
		SELECT id, race, emotion, oldness, closest_state
		FROM $tableName
		WHERE closest_state >= :closestTo
		ORDER BY closest_state ASC
		LIMIT 5
	) UNION ALL (
		SELECT id, race, emotion, oldness, closest_state
		FROM $tableName
		WHERE closest_state < :closestTo
		ORDER BY closest_state DESC
		LIMIT 5
	)
) AS n
ORDER BY distance
LIMIT 5
SQL;
        $stmt = $this->getConnection()->prepare($selectSql);
        $stmt->bindValue(':closestTo', $closestState, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return PDO
     */
    private function getConnection()
    {
        if ($this->connection === null) {
            $dsn = 'mysql:host=pikabu-mysql;';
            $username = 'root';
            $password = '';
            $options = [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            ];

            $this->connection = new \PDO($dsn, $username, $password, $options);
        }

        return $this->connection;
    }

    /**
     * @return bool
     */
    private function prepareDb()
    {
        $prepared = true;
        $createDbSql = 'CREATE DATABASE IF NOT EXISTS ' . self::DB_NAME;
        $prepared = $prepared && $this->getConnection()->exec($createDbSql) !== false;
        $prepared = $prepared && $this->getConnection()->exec('USE ' . self::DB_NAME) !== false;

        return $prepared;
    }

    /**
     * @return bool
     */
    private function prepareTable()
    {
        $tableName = self::TABLE_NAME;
        $createTableSql = <<<SQL
        CREATE TABLE IF NOT EXISTS $tableName
(
	id int auto_increment,
	race tinyint unsigned not null,
	emotion smallint unsigned not null,
	oldness smallint unsigned not null,
	closest_state smallint unsigned not null,
	index (closest_state),
	constraint faces_pk
		primary key (id)
		
);
SQL;

        return $this->getConnection()->exec($createTableSql) !== false;
    }
}

$ff = new FaceFinder();