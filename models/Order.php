<?php

namespace app\models;

class Order extends Record
{
    public $id;
    public $date;
    public $user_id;
    public $status;

    public function __construct(int $id = null,  $date = null, int $user_id = null, int $status = null)
    {
        parent::__construct();
        $this->id = $id;
        $this->date = $date;
        $this->user_id = $user_id;
        $this->status = $status;
        $this->propsExclusion[]='date';
    }

    public function setStatus($status)
    {
        $this->setPropsIsUpdated('status');
        $this->status = $status;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->setPropsIsUpdated('user_id');
        $this->user_id = $user_id;
    }
}