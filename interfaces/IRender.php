<?php


namespace app\interfaces;


interface IRender
{
    public function getContent(string $template, array $params = []);
}