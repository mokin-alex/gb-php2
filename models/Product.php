<?php
namespace app\models;


class Product extends Model
{
    private $id;
    protected $name;
    protected $description;
    protected $price;
    protected $imageData;
    protected $imageType;
    protected $viewers;

    public function getTableName(): string
    {
        return "products";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}