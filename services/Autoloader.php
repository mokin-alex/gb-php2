<?php
namespace services;

class Autoloader
{
    public function loadClass(string $classname)
    {
           if (realpath("../{$classname}.php")){
                require realpath("../{$classname}.php");
                return true;
            }
        return false;
    }
}