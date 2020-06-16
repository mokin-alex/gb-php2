<?php

namespace app\models;

use app\interfaces\RecordInterface;
use app\services\Db;

abstract class Record implements RecordInterface
{
    protected $tableName;
    protected $db = null;
    protected $classname;
    public $id;
    protected $propsExclusion;

    public function __construct()
    {
        $this->db = Db::getInstance();
        $this->tableName = $this->getTableName();
        $this->classname = get_class($this);
        $this->setPropsExclusion();
    }

    public function setPropsExclusion()
    {
        $this->propsExclusion = ['id', 'db','tableName', 'classname', 'propsExclusion'];
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = :id";
        return $this->db->queryOne($this->classname, $sql, [':id' => $id]);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->tableName}";
        return $this->db->queryAll($this->classname, $sql);

    }

    public function insert()
    {
        $tableName = $this->tableName; //static::getTableName();
        $params = [];
        $columns = [];

        foreach ($this as $key => $value) {
            if(in_array($key, $this->propsExclusion)) {
                continue;
            }

            $params[":{$key}"] = $value;
            $columns[] = "`{$key}`";
        }

        $columns = implode(", ", $columns);
        $placeholders = implode(", ", array_keys($params));

        $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        $this->id = $this->db->getLastInsertId();
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = :id";
        return $this->db->execute($sql, [':id' => $this->id]);
    }

    public function save()
    {
        if (is_null($this->id)) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

}