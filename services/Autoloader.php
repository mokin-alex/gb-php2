<?php
namespace app\services;

class Autoloader
{
    private $fileExtension = ".php";

    public function loadClass(string $classname)
    {
        $classname = str_replace('app\\', ROOT_DIR, $classname);
           if (realpath("{$classname}{$this->fileExtension}")){
                require realpath("{$classname}{$this->fileExtension}");
                return true;
            }
        return false;
    }
}