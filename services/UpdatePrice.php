<?php


namespace app\services;


class UpdatePrice
{
    protected $fileName;
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
            );
        }
        return $this->connection;
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

    private function query(string $sql, array $params = []) {
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    public function execute(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->errorInfo();
    }


    public function __construct(string $fileName)
    {
        $this->fileName= $fileName;
    }

    public function loadFileToTmpTable()
    {
        $sql = "LOAD DATA INFILE '{$this->fileName}'
        INTO TABLE csv_file
        COLUMNS TERMINATED BY ';'
        OPTIONALLY ENCLOSED BY '\"'
        LINES TERMINATED BY '\n'
        IGNORE 1 LINES
        (id,price);";
        return $this->execute($sql);
    }

    public function updatePrice()
    {
        $sql="UPDATE products, csv_file
        SET products.price = csv_file.price
        WHERE products.id=csv_file.id;";
        return $this->execute($sql);
    }

    public function clearTmpTable()
    {
        $sql = "TRUNCATE TABLE csv_file;";
        return $this->execute($sql);
    }
}