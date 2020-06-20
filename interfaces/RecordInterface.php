<?php

namespace app\interfaces;

interface RecordInterface
{
    public static function getById(int $id);

    public static function getAll(): array;

    public static function getTableName(): string;

    public function update();
    public function insert();
    public function delete();
    public function save();
    public function setPropsExclusion();
}