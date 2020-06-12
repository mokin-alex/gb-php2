<?php

namespace app\interfaces;

interface ModelInterface
{
    public function getById(int $id);

    public function getALl(): array;

    public function getTableName(): string;

    public function update();
    public function insert();
    public function delete();
}