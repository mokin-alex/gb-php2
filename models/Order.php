<?php
namespace app\models;
use app\interfaces\ModelInterface;
use app\interfaces\OrderInterface;

class Order extends Model implements ModelInterface, OrderInterface
{
    protected $id;
    protected $date;
    protected $user_id;
    protected $status;
    protected $productsList = [];

    public function getTableName(): string
    {
        return "orders";
    }

    public function getProductsInOrder(): array
    {
        //$sql = "SELECT * FROM order_product WHERE order_id = {$this->id}";
        $sql = "SELECT * FROM {$this::TABLE_WITH_PRODUCTS_OF_ORDER} WHERE order_id = {$this->id}";
        return $this->db->queryAll($sql);
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
        $this->status = $status;
    }

}