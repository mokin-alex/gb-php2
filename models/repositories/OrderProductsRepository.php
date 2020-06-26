<?php


namespace app\models\repositories;


use app\models\OrderProducts;

class OrderProductsRepository extends Repository
{

    public static function getTableName(): string
    {
        return "order_products";
    }

    public function getRecordClass(): string
    {
        return OrderProducts::class;
    }
}