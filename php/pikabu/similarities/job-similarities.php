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

    public function __construct(int $race, int $emotion, int $oldness, $id = null)
    {
    }

    public function getId(): int
    {
        // TODO: Implement getId() method.
    }

    public function getRace(): int
    {
        // TODO: Implement getRace() method.
    }

    public function getEmotion(): int
    {
        // TODO: Implement getEmotion() method.
    }

    public function getOldness(): int
    {
        // TODO: Implement getOldness() method.
    }
}

class FaceFinder implements FaceFinderInterface
{
    private const DB_NAME = 'face_finder';
    /** @var PDO */
    private $connection;

    public function __construct()
    {
        $this->prepareDb();
    }

    public function resolve(FaceInterface $face): array
    {
        // TODO: Implement resolve() method.
    }

    public function flush(): void
    {
        // TODO: Implement flush() method.
    }

    private function prepareDb()
    {
        $dsn = 'mysql:host=pikabu-mysql;';
        $username = 'root';
        $password = '';
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ];

        $this->connection = new PDO($dsn, $username, $password, $options);

        $sql = 'CREATE DATABASE IF NOT EXISTS face_finder;';
        return $this->connection->exec($sql);
    }
}

$ff = new FaceFinder();