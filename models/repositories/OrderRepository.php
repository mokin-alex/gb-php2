<?php


namespace app\models\repositories;


use app\models\Order;
use app\services\Db;

class OrderRepository extends Repository
{

    public static function getTableName(): string
    {
        return "orders";
    }

    public function getRecordClass(): string
    {
        return Order::class;
    }

    function setOrderStatus(array $orderIds, int $status)
    {
        $tableName = static::getTableName();
        $in = implode(", ", $orderIds);
        $sql = "UPDATE {$tableName} SET status = :status WHERE id IN (:in)";
        return Db::getInstance()->execute($sql, [':status' => $status, ':in' => $in]);
    }
}