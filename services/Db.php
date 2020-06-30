<?php

namespace app\services;

use PDO;

class Db
{
    protected $config;

    public function __construct($driver, $host, $login, $password, $database, $charset)
    {
        $this->config = [
            'driver' => $driver,
            'host' => $host,
            'login' => $login,
            'password' => $password,
            'database' => $database,
            'charset' => $charset
        ];
    }

    /**
     * @var PDO
     */
    private $connection = null;

    public function getConnection()
    {
        if (is_null($this->connection)) {
            $this->connection = new PDO(
                $this->buildDsnString(),
                $this->config['login'],
                $this->config['password']
            );

            $this->connection->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );
        }

        return $this->connection;
    }

    private function query(string $sql, array $params = [])
    {
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    public function execute(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function getLastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }

    public function queryOne(string $classname, string $sql, array $params = [])
    {
        return $this->queryAll($classname, $sql, $params)[0];
    }

    public function queryAll(string $classname, string $sql, array $params = [])
    {
        //$queryCollection = [];
        $pdoStatement = $this->query($sql, $params);
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $classname);
        return $pdoStatement->fetchAll();
//        while ($queryItem = $pdoStatement->fetchObject($classname)) {
//            $queryCollection[] = $queryItem;
//        }
//        return $queryCollection;

    }

    private function buildDsnString()
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset'],
        );
    }
}