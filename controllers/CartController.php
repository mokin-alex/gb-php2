<?php

namespace app\controllers;

use app\models\Cart;
use app\models\repositories\ProductRepository;

class CartController extends Controller
{
    public function actionIndex()
    {
        $cart = (new Cart())->getCartContent();
        foreach ($cart as $prod => $itm) {
            $product = (new ProductRepository())->getById($itm['id']);
            $cart[$prod]['imageType'] = $product->imageType;
            $cart[$prod]['imageData'] = $product->imageData;
        }
        echo $this->render('view_cart', ['cart' => $cart, 'user' => $this->currentUser]);
    }

    public function actionRemove()
    {
        if ($this->request->isPost()) {
            if ($this->request->isSet('remove')) { //Удалить один или несколько продуктов из массива(в сессии)
                $cart = new Cart();
                $cart->remove($this->request->dirtyPost('product_item'));
            }
        }
        $this->redirect('/cart');
    }

    public function actionRemoveAll()
    {
        $cart = new Cart();
        $cart->clear();  //Очистить корзину
        $this->redirect('/cart');
    }
}