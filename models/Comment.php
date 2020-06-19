<?php

namespace app\models;

class Comment extends Record implements \app\interfaces\RecordInterface
{
    public $product_id;
    public $text;

    public function __construct(int $product_id = null, string $text = null)
    {
        parent::__construct();
        $this->product_id = $product_id;
        $this->text = $text;
    }

    public function getTableName(): string
    {
        return "comments";
    }
}