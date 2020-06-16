<?php


namespace app\controllers;


use app\models\Product;
use app\models\RenderToLayout;

use app\traits\TController;

class CartController
{
    use TController;
    public function actionIndex()
    {
        session_start();
        if (isset($_SESSION['user_name'])) {
            $userName = $_SESSION['user_name'];
        } else {
            $userName = "Посетитель";
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (empty($_SESSION['cart'])) {
            $cartInfo = $userName . ", ваша корзина пуста";
        } else {
            $cartInfo = $userName . ", сейчас в корзине:";
        }

        $cart = $_SESSION['cart']; //получим текущее состояние корзины из сессии
        //Для вывода на экран добавим в массив Корзины  фото, взяв его из базы по id продукта:
        foreach ($cart as $prod => $itm) {
            $product = (new Product())->getById($itm['id']);
            $cart[$prod]['imageType'] = $product->imageType;
            $cart[$prod]['imageData'] = $product->imageData;
        }
        $justRendered = new RenderToLayout('view_cart', ['cart' => $cart, 'cartInfo' => $cartInfo]);
        echo $justRendered->getContent();
    }

    public function actionRemove()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            session_start();
            if (isset($_POST['remove'])) { //Удалить один или несколько продуктов из массива(в сессии)
                foreach ($_POST['product_item'] as $product_line) {
                    unset($_SESSION['cart'][$product_line]);
                }
            }
            if (isset($_POST['removeAll'])) { //Очистить корзину
                unset($_SESSION['cart']);
            }
            $this->redirect('?c=cart');
        }
    }
}