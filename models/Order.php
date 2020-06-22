<?php

namespace app\models;

use app\interfaces\IRecord;
use app\interfaces\OrderInterface;

class Order extends Record implements IRecord, OrderInterface
{
    //public $id;
    public $date;
    public $user_id;
    public $status;
    public $productsList = [];

    public function __construct(int $user_id = null, int $status = null)
    {
        parent::__construct();
        $this->user_id = $user_id;
        $this->status = $status;
    }

    public static function getTableName(): string
    {
        return "orders";
    }

    public static function getOrdersByUser(int $user_id)
    {
        //TODO:
    }

    public function getProductsInOrder(): array
    {
        //TODO: тут запрос реализован не правильно - переделать
        $sql = "SELECT * FROM $this::TABLE_WITH_PRODUCTS_OF_ORDER WHERE order_id = {$this->id}";
        return $this->db->queryAll($sql, [], 'app\models\ProductQnt');
    }

    public function addProductInOrder(ProductQnt $productQnt)
    {
        $this->productsList[] = $productQnt;
        //TODO: записать в БД
    }

    public function removeProductInOrder(ProductQnt $productQnt)
    {
        // TODO: Implement removeProductInOrder() method.
    }

    public function setStatus($status)
    {
        $this->setPropsIsUpdated('status');
        $this->status = $status;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->setPropsIsUpdated('user_id');
        $this->user_id = $user_id;
    }
}