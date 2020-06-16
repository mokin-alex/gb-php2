<?php

namespace app\interfaces;

interface RecordInterface
{
    public function getById(int $id);

    public function getAll(): array;

    public function getTableName(): string;

    public function update();
    public function insert();
    public function delete();
    public function save();
    public function setPropsExclusion();
}