<?php

namespace app\models;

use app\interfaces\IRecord;

abstract class Record implements IRecord
{
    public $id;
    public $propsExclusion;//свойства-искючения для инсерта.
    public $propsIsUpdated;

    public function __construct()
    {
        $this->propsIsUpdated = [];
        $this->propsExclusion = ['id', 'propsExclusion', 'propsIsUpdated'];
    }

    public function setPropsIsUpdated(string $propName)
    {
        $prepare = $this->propsIsUpdated;
        $prepare[] = $propName; //добавим имя свойства
        $this->propsIsUpdated = array_unique($prepare); //исключим повторяющиеся имена свойств.
    }

}