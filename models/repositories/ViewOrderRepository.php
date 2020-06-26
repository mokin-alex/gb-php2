<?php


namespace app\models\repositories;


use app\models\ViewOrder;
use app\services\Db;

class ViewOrderRepository
{
    protected $db = null;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function getRecordClass(): string
    {
        return ViewOrder::class;
    }

    function getOrdersByUser(int $userId)
    {
        $sql = "SELECT `orders`.id, `orders`.date, `order_status`.status, count(order_products.product_id) as  product_quantity, sum(order_products.quantity) as copies, sum(products.price * order_products.quantity) as summa
            FROM `orders`,
            `order_products`,
            `products`,
            `order_status`
            WHERE order_products.order_id = `orders`.id
            and order_products.product_id = products.id
            and order_status.id=`orders`.status
            and `orders`.user_id = :user_id
            group by `orders`.id;";
        return Db::getInstance()->queryAll(static::getRecordClass(), $sql, [':user_id' => $userId]);
    }

    function getOrdersAllUsers()
    {
        $sql = "SELECT `orders`.id, `orders`.date, `order_status`.status, count(order_products.product_id) as  product_quantity, sum(order_products.quantity) as copies, sum(products.price * order_products.quantity) as summa
            FROM `orders`,
            `order_products`,
            `products`,
            `order_status`
            WHERE order_products.order_id = `orders`.id
            and order_products.product_id = products.id
            and order_status.id=`orders`.status
            group by `orders`.user_id, `orders`.id, `orders`.date
            ORDER BY `orders`.date DESC";
        return Db::getInstance()->queryAll(static::getRecordClass(), $sql);
    }
}