<?php
require $_SERVER['DOCUMENT_ROOT'] . "/../config/main.php";
require ROOT_DIR . "services/Autoloader.php";

spl_autoload_register([new app\services\Autoloader(), 'loadClass']);


$controllerName = (empty($_GET['c'])) ? 'product' : $_GET['c'];
$actionName = $_GET['a'];

$controllerClass = "app\controllers\\" . ucfirst($controllerName) . "Controller";

if(class_exists($controllerClass)) {
    /** @var \app\controllers\ProductController $controller */
    $controller = new $controllerClass;
    $controller->runAction($actionName);
}


//$product = new app\models\Product();
//$product->setCategoryId(111)
//        ->setDescription("test");

//var_dump($product->getById('10'));

//var_dump($product);
//$order = new app\models\Order();
//var_dump($order->getAll());
//var_dump($order->getById(1)->getProductsInOrder());
//$user = new app\models\User();
//$user->setLogin("petrovaa");
//$user->setPassword("test");
//$user->setFistName('Alexandr')->setSecondName("Petrov");
//$user->setIsAdm(false);
//var_dump($user->getById(3));
//var_dump($user->getAll());
//var_dump($user->insert()->errorInfo());
//$user->getById(3)->delete();

