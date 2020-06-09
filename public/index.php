<pre>
<?php

require $_SERVER['DOCUMENT_ROOT'] . "/../services/Autoloader.php";

spl_autoload_register([new \services\Autoloader(), 'loadClass']);

$product = new \models\Product();
$product->setCategoryId(111)
    ->setDescription("test");

function foo(\interfaces\ModelInterface $object){
    var_dump($object->getById());
}

var_dump($product);
$order= new \models\Order();
