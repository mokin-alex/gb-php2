<?php


namespace app\models;


class ProductQnt extends Product
{
    protected $quantity;

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getSubtotal(): float
    {
        return $this->quantity*$this->getPrice();
    }
}