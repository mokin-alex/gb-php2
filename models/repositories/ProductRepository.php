<?php


namespace app\models\repositories;


use app\models\Product;

class ProductRepository extends Repository
{
    public static function getTableName(): string
    {
        return "products";
    }

    public function getRecordClass(): string
    {
        return Product::class;
    }

}