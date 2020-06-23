<?php


namespace app\services;


abstract class Request
{

    public static function cleanGet($name):string
    {
        return htmlspecialchars(strip_tags($_GET[$name]));
    }

    public static function dirtyPost($name)
    {
        return $_POST[$name];
    }

    public static function cleanPost($name):string
    {
        return htmlspecialchars(strip_tags($_POST[$name]));
    }

    public static function isPost():bool
    {
       return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public static function isSet($name):bool
    {
        return isset($_POST[$name]);
    }
}