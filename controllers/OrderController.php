<?php

namespace app\controllers;

use app\models\Cart;
use app\models\OrderProducts;
use app\models\repositories\OrderProductsRepository;
use app\models\repositories\OrderRepository;
use app\models\repositories\ViewOrderRepository;
use app\services\Request;

class OrderController extends Controller
{
    const ORDER_PAYED = 1;
    const ORDER_DELIVERED = 2;
    const ORDER_CLOSED = 3;
    const ORDER_CANCEL = 9;

    public function actionIndex()
    {
        if ($this->currentUser) {
            $orders = (new ViewOrderRepository())->getOrdersByUser((int)$this->currentUser->getId());
            echo $this->render('view_orders', ['orders' => $orders]);
        } else {
            $this->redirect('/auth/login');
        }
    }

    public function actionManage()
    {
        if ($this->currentUser && $this->currentUser->getIsAdm()) {
            $orders = (new ViewOrderRepository())->getOrdersAllUsers();
            echo $this->render('view_orders_adm', ['orders' => $orders]);
        } else {
            $this->redirect('/auth/login');
        }
    }

    public function actionAdd()
    {
        if (!$this->currentUser) $this->redirect('/auth/login');
        $order = new Order();
        (new OrderRepository())->save($order);
        $cart = (new Cart())->getCartContent();
        foreach ($cart as $prod => $itm) {
            $orderProduct = new OrderProducts();
            $orderProduct->setOrderId($order->getId());
            $orderProduct->setProductId($cart[$prod]['id']);
            $orderProduct->setQuantity($cart[$prod]['quantity']);
            (new OrderProductsRepository())->save($orderProduct);
        }
        $this->redirect('/order');
    }

    public function actionUpdate()
    {
        if (!$this->currentUser) $this->redirect('/auth/login');
        $request = new Request();
        if ($request->isPost()) {
            $orderIds = $request->dirtyPost('order_item');

            if ($this->session->isSet('pay')) {
                (new OrderRepository())->setOrderStatus($orderIds, ORDER_PAYED); //Оплачен заказ
            }
            if ($this->session->isSet('cancel')) {
                (new OrderRepository())->setOrderStatus($orderIds, ORDER_CANCEL); //отмена заказа
            }
            if ($this->session->isSet('close')) {
                (new OrderRepository())->setOrderStatus($orderIds, ORDER_CLOSED); //закрыть заказ как законченный
            }
            if ($this->session->isSet('delivery')) {
                (new OrderRepository())->setOrderStatus($orderIds, ORDER_DELIVERED); //заказ доставлен
            }
        }

        if ($this->currentUser && $this->currentUser->getIsAdm()) {
            $this->redirect('/order/manage');
        } else {
            $this->redirect('/order');
        }
    }
}