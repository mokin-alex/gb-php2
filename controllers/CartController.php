<?php

namespace app\controllers;

use app\models\Cart;
use app\models\repositories\ProductRepository;
use app\services\Request;

class CartController extends Controller
{
    public function actionIndex()
    {
        if ($this->currentUser)  {
            $userName = $this->currentUser->getFirstName();
        } else {
            $userName = "Посетитель";
        }

        $cart = (new Cart())->getCartContent();
        if (empty($cart)) {
            $cartInfo = $userName . ", ваша корзина пуста";
        } else {
            $cartInfo = $userName . ", офрмите заказ";
        }
        foreach ($cart as $prod => $itm) {
            $product = (new ProductRepository())->getById($itm['id']);
            $cart[$prod]['imageType'] = $product->imageType;
            $cart[$prod]['imageData'] = $product->imageData;
        }
        echo $this->render('view_cart', ['cart' => $cart, 'cartInfo' => $cartInfo]);
    }

    public function actionRemove()
    {
        $request = new Request();

        if ($request->isPost()) {
            $cart = new Cart();
            if ($request->isSet('remove')) { //Удалить один или несколько продуктов из массива(в сессии)
                $cart->remove($request->dirtyPost('product_item'));
            }
            if ($request->isSet('removeAll')) { //Очистить корзину
                $cart->clear();
            }
        }
        $this->redirect('/cart');
    }
}