<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Order;
use app\models\OrderProducts;
use app\models\repositories\OrderProductsRepository;
use app\models\repositories\OrderRepository;
use app\models\repositories\ViewOrderRepository;

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
        if (!$this->currentUser) {
            $this->redirect('/auth/login');
        }
        $order = new Order();
        $order->setUserId($this->currentUser->getId());
        (new OrderRepository())->save($order);
        $cart = (new Cart())->getCartContent();
        $order->addProductsToOrder($cart);
        $this->redirect('/order');
    }

    public function actionUpdate()
    {
        if (!$this->currentUser) {
            $this->redirect('/auth/login');
        }
        if ($this->request->isPost()) {
            $orderIds = $this->request->dirtyPost('order_item');

            if ($this->request->isSet('pay')) {
                (new OrderRepository())->setOrderStatus($orderIds, ORDER_PAYED); //Оплачен заказ
            }
            if ($this->request->isSet('cancel')) {
                (new OrderRepository())->setOrderStatus($orderIds, ORDER_CANCEL); //отмена заказа
            }
            if ($this->request->isSet('close')) {
                (new OrderRepository())->setOrderStatus($orderIds, ORDER_CLOSED); //закрыть заказ как законченный
            }
            if ($this->request->isSet('delivery')) {
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