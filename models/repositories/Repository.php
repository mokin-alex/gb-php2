<?php


namespace app\models\repositories;


use app\models\Record;
use app\services\Db;

abstract class Repository
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    abstract public function getRecordClass(): string;

    public function getById(int $id): Record
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return Db::getInstance()->queryOne($this->getRecordClass(), $sql, [':id' => $id]);
    }

    public function getAll(): array
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return Db::getInstance()->queryAll($this->getRecordClass(), $sql);
    }

    public function insert(Record $record)
    {
        $tableName = static::getTableName();
        $params = [];
        $columns = [];

        foreach ($record as $key => $value) {
            if (in_array($key, $record->propsExclusion)) {
                continue;
            }

            $params[":{$key}"] = $value;
            $columns[] = "`{$key}`";
        }

        $columns = implode(", ", $columns);
        $placeholders = implode(", ", array_keys($params));

        $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        $record->id = $this->db->getLastInsertId();
    }

    public function update(Record $record)
    {
        $tableName = static::getTableName();
        $params = [':id' => $record->id];
        $placeholder = [];
        foreach ($record->propsIsUpdated as $item => $prop) {
            $params[":{$prop}"] = $record->{$prop};
            $placeholder[] = "{$prop} = :{$prop}";
        }
        $placeholders = implode(", ", $placeholder);
        $sql = "UPDATE {$tableName} SET {$placeholders} WHERE id = :id";
        $record->propsIsUpdated = []; //очистим для следующего апдейта.
        return $this->db->execute($sql, $params);
    }

    public function delete(Record $record)
    {
        $tableName = static::getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id = :id";
        return $this->db->execute($sql, [':id' => $record->id]);
    }

    public function save(Record $record)
    {
        if (is_null($record->id)) {
            return $this->insert($record);
        } else {
            return $this->update($record);
        }
    }
}