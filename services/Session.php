<?php


namespace app\services;


class Session
{
    public function __construct()
    {
        session_start();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }

    public function clear($key)
    {
        unset($_SESSION[$key]);
    }

    public function isSet($key)
    {
        return isset($_SESSION[$key]);
    }

    public function close()
    {
        $_SESSION = [];
    }
}