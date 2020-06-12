<?php
namespace app\models;
use app\interfaces\ModelInterface;
use app\services\Db;
use mysql_xdevapi\DatabaseObject;

abstract class Model implements ModelInterface
{
    protected $tableName;
    protected $db = null;
    protected $classname;

    public function __construct()
    {
        $this->db = Db::getInstance();
        $this->tableName = $this->getTableName();
        $this->classname = get_class($this);
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = :id";
        return $this->db->queryOne($sql, [':id' => $id], $this->classname);
    }

    public function getALl():array
    {
        $sql = "SELECT * FROM {$this->tableName}";
        return $this->db->queryAll($sql, [], $this->classname);
    }

    abstract function update();
    abstract function insert();

}