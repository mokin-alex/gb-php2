<?php

namespace app\models;

class Comment extends Record
{
    public $product_id;
    public $text;

    public function __construct(int $productId = null, string $text = null)
    {
        parent::__construct();
        $this->product_id = $productId;
        $this->text = $text;
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
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->setPropsIsUpdated('text');
        $this->text = $text;
    }

}