<?php
namespace app\services;
use app\models\Model;
use app\traits\TSingleton;

class Db
{
    use TSingleton;

    private $config = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'root',
        'password' => 'root',
        'database' => 'june',
        'charset' => 'utf8',
    ];

    /**
     * @var \PDO
     */
    private $connection = null;

    public function getConnection()
    {
        if (is_null($this->connection)) {
            $this->connection = new \PDO(
                $this->buildDsnString(),
                $this->config['login'],
                $this->config['password']
            );

            $this->connection->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC
             //   \PDO::FETCH_INTO
            );
        }

        return $this->connection;
    }

    private function query(string $sql, array $params = []) {
        $pdoStatement = $this->getConnection()->prepare($sql);
     //   $pdoStatement::setFetchMode ( \PDO::FETCH_INTO, $obj );
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    public function update(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function insert(string $sql, array $params = [])
    {
        $this->query($sql, $params);
        return $this->getConnection()->lastInsertId();
    }

    public function queryOne(string $sql, array $params = [])
    {
        //return $this->queryAll($sql, $params)[0];
        $obj = $this->query($sql, $params)->fetch(\PDO::FETCH_OBJ);
        var_dump($obj);
        return [];
        //return $array[$obj];
    }

    public function queryAll(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
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