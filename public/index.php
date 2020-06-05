<?php

class ProductItem
{
    public $id;
    public $image;
    public $author;
    public $description;
    private $price;
    private $discount; //скидка
    private $rating; //количество просмотров

    public function __construct(int $id, $image, string $author, string $description, float $price, float $discount = 0, int $rating = 0)
    {
        $this->id = $id;
        $this->image = $image;
        $this->author = $author;
        $this->description = $description;
        $this->price = $price;
        $this->discount = $discount;
        $this->rating = $rating;
    }

    public function incRating() // увеличение количества просмотров
    {
        ++$this->rating;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price - $this->discount;
    }
    public function setDiscount(float $discount)
    {
        $this->discount = $discount;
    }
    public function getDiscount():float
    {
        return $this->discount;
    }
}

class CartItem extends ProductItem
//Класс продукта в корзине, со свойством количество и методом "цена товара в данном количесвте"
{
    private $quantity; //количество экз. в корзине

    public function __construct(int $id, $image, string $author, string $description, float $price, float $discount =0, int $rating = 0, int $quantity = 1)
    {
        parent::__construct($id, $image, $author, $description, $price, $discount, $rating);
        $this->quantity = $quantity;
    }

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


