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

    private function getParams(): array
    {
        return $params = [
            ':user_id' => $this->user_id,
            ':status' => $this->status,
        ];
    }

    public function insert()
    {
        $sql = "INSERT INTO {$this->tableName} (user_id, status) 
                VALUE (:user_id, :status)";
        return $this->db->insert($sql, $this->getParams());
    }

    public function update()
    {
        $sql = "UPDATE {$this->tableName} 
            SET user_id = :user_id, status = :status
            WHERE id = {$this->id}";
        return $this->db->insert($sql, $this->getParams());
    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = {$this->id}";
        return $this->db->execute($sql);
    }

    public function getProductsInOrder(): array
    {
        //TODO: тут запрос реализован не правильно - переделать
        $sql = "SELECT * FROM $this::TABLE_WITH_PRODUCTS_OF_ORDER WHERE order_id = {$this->id}";
        return $this->db->queryAll($sql,[], 'app\models\ProductQnt');
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

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }
}