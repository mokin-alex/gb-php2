<?php

namespace app\models;

use app\interfaces\IRecord;
use app\services\Db;

abstract class Record implements IRecord
{
    protected $tableName;
    protected $db = null;
    protected $classname;
    public $id;
    protected $propsExclusion; //свойства-искючения для инсерта.
    protected $propsIsUpdated = [];

    public function __construct()
    {
        $this->db = Db::getInstance();
        $this->tableName = static::getTableName();
        $this->classname = get_class($this);
        $this->setPropsExclusion();
    }

    public function setPropsExclusion()
    {
        $this->propsExclusion = ['id', 'db', 'tableName', 'classname', 'propsExclusion', 'propsIsUpdated'];
    }

    protected function setPropsIsUpdated(string $propName)
    {
        $prepare = $this->propsIsUpdated;
        $prepare[] = $propName; //добавим имя свойства
        $this->propsIsUpdated = array_unique($prepare); //исключим повторяющиеся имена свойств.
    }

    public static function getById(int $id)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return Db::getInstance()->queryOne(get_called_class(), $sql, [':id' => $id]);
    }

    public static function getAll(): array
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return Db::getInstance()->queryAll(get_called_class(), $sql);
    }

    public function insert()
    {
        $tableName = $this->tableName; //static::getTableName();
        $params = [];
        $columns = [];

        foreach ($this as $key => $value) {
            if (in_array($key, $this->propsExclusion)) {
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
        $params = [];
        $placeholder = [];
        foreach ($this->propsIsUpdated as $item => $prop) {
            $params[":{$prop}"] = $this->{$prop};
            $placeholder[] = "{$prop} = :{$prop}";
        }
        $placeholders = implode(", ", $placeholder);
        $sql = "UPDATE {$this->tableName} SET {$placeholders} WHERE id = {$this->id}";
        $this->propsIsUpdated = []; //очистим для следующего апдейта.
        return $this->db->execute($sql, $params);
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