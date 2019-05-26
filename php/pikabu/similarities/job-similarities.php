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
    private $id;
    private $race;
    private $emotion;
    private $oldness;

    public function __construct(int $race, int $emotion, int $oldness, $id = 0)
    {
        $this->race = $race;
        $this->emotion = $emotion;
        $this->oldness = $oldness;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRace(): int
    {
        return $this->race;
    }

    public function getEmotion(): int
    {
        return $this->emotion;
    }

    public function getOldness(): int
    {
        return $this->oldness;
    }
}

class FaceFinder implements FaceFinderInterface
{
    private const DB_NAME = 'face_finder';
    private const TABLE_NAME = 'faces';
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
        if (!$face->getId()) {
            $this->storeFace($face);
        }
        $resolvedFaces = [];
        $resolvedLs = new SplMaxHeap();
        foreach ($this->getAllFaces() as $face2) {
            $l = \sqrt(
                ($face->getRace() - $face2->race) ** 2
                + ($face->getEmotion() - $face2->emotion) ** 2
                + ($face->getOldness() - $face2->oldness) ** 2
            );
            if ($resolvedLs->count() === 0) {
                $resolvedLs->insert([$l, $face2->id]);
                $resolvedFaces[$face2->id] = new Face($face2->race, $face2->emotion, $face2->oldness, $face2->id);
            } elseif ($resolvedLs->count() > 5) {
                $value = $resolvedLs->extract();
                unset($resolvedFaces[$value[1]]);
            }
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
     * @param FaceInterface $face
     * @return bool
     */
    private function storeFace(FaceInterface $face)
    {
        $tableName = self::TABLE_NAME;

        $insertSql = <<<SQL
INSERT INTO $tableName (race, emotion, oldness) VALUES (:race, :emotion, :oldness)
SQL;
        $stmt = $this->getConnection()->prepare($insertSql);
        $stmt->bindParam(':race', $face->getRace());
        $stmt->bindParam(':emotion', $face->getEmotion());
        $stmt->bindParam(':oldness', $face->getOldness());

        return $stmt->execute();
    }

    /**
     * @return bool|PDOStatement
     */
    private function getAllFaces()
    {
        $stmt = $this->getConnection()->prepare(
            'SELECT * FROM ' . self::TABLE_NAME,
            [PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false]
        );
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();

        return $stmt;
    }

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
	constraint faces_pk
		primary key (id)
);
SQL;

        return $this->getConnection()->exec($createTableSql) !== false;
    }
}

$ff = new FaceFinder();