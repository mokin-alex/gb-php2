<?php


namespace app\models\repositories;


use app\models\Record;
use app\models\User;
use app\services\Db;

class UserRepository extends Repository
{

    public static function getTableName(): string
    {
        return "users";
    }

    public function getRecordClass(): string
    {
        return User::class;
    }

    public function getUserByLogin(string $login):Record
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE  login = :login";
        return Db::getInstance()->queryOne(static::getRecordClass(), $sql, [':login' => $login]);
    }
}