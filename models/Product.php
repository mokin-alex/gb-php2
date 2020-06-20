<?php

namespace app\models;


class Product extends Record
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $imageData;
    public $imageType;
    public $viewers;

    public static function getTableName(): string
    {
        return "products";
    }

    public function __construct($id = null, $name = null, $description = null, $price = null, $imageData = null, $imageType = null, $viewers = 0)
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->imageData = $imageData;
        $this->imageType = $imageType;
        $this->viewers = $viewers;
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

    /**
     * @return mixed
     */
    public function getImageData()
    {
        return $this->imageData;
    }

    /**
     * @param mixed $imageData
     */
    public function setImageData($imageData): void
    {
        $this->imageData = $imageData;
    }

    /**
     * @return mixed
     */
    public function getImageType()
    {
        return $this->imageType;
    }

    /**
     * @param mixed $imageType
     */
    public function setImageType($imageType): void
    {
        $this->imageType = $imageType;
    }

    /**
     * @return mixed
     */
    public function getViewers()
    {
        return $this->viewers;
    }

    /**
     * @param mixed $viewers
     */
    public function setViewers($viewers): void
    {
        $this->viewers = $viewers;
    }

    public function getComments()
    {
        return []; //TODO: получение коментариев по конкретному товару
    }
}