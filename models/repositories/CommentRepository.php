<?php


namespace app\models\repositories;


use app\models\Comment;
use app\services\Db;

class CommentRepository extends Repository
{


    public static function getTableName(): string
    {
        return "comments";
    }

    public function getRecordClass(): string
    {
        return Comment::class;
    }

    public function getCommentsByProductId(int $productId):array
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE  product_id = :product_id";
        return Db::getInstance()->queryAll(static::getRecordClass(), $sql, [':product_id' => $productId]);
    }
}