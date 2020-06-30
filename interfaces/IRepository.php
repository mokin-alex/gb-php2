<?php
namespace app\interfaces;

interface IRepository
{
    public static function getById(int $id): IRepository;

    public static function getAll();

    public static function getTableName(): string;

    public function delete();

    public function insert();

    public function update();

    public function save();

}