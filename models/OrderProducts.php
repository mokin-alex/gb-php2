<?php


namespace app\models;


class OrderProducts extends Record
{
    public $id;
    public $order_id;
    public $product_id;
    public $quantity;

    public function __construct(int $id = null, int $orderId = null, int $productId = null, int $quantity = 0)
    {
        parent::__construct();
        $this->id = $id;
        $this->order_id = $orderId;
        $this->product_id = $productId;
        $this->quantity = $quantity;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->order_id;
    }

    /**
     * @param int|null $order_id
     */
    public function setOrderId(?int $order_id): void
    {
        $this->setPropsIsUpdated('order_id');
        $this->order_id = $order_id;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    /**
     * @param int|null $product_id
     */
    public function setProductId(?int $product_id): void
    {
        $this->setPropsIsUpdated('product_id');
        $this->product_id = $product_id;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->setPropsIsUpdated('quantity');
        $this->quantity = $quantity;
    }


}