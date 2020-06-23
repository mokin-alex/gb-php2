<?php


namespace app\controllers;


use app\models\Order;
use app\services\Request;

class OrderController extends Controller
{
    public function actionIndex()
    {
        if ($this->currentUser) {
            $orders = Order::getOrdersByUser((int)$this->currentUser->getId());
            echo $this->render('view_orders', ['orders' => $orders]);
        } else {
            $this->redirect('/?c=auth&a=login');
        }
    }

    public function actionManage()
    {
        if ($this->currentUser && $this->currentUser->getIsAdm()) {
            $orders = Order::getAll();
            echo $this->render('view_orders_adm', ['orders' => $orders]);
        } else {
            $this->redirect('/?c=auth&a=login');
        }
    }

    public function actionAdd()
    {
        if (!$this->currentUser) $this->redirect('/?c=auth&a=login');
        //TODO: доделать добавление заказа
        //
        $this->redirect('/?c=order');
    }

    public function actionUpdate()
    {
        if (!$this->currentUser) $this->redirect('/?c=auth&a=login');

        if (Request::isPost()) {
            $orderIds = Request::dirtyPost('order_item');

            //TODO: доделать изменение статуса заказов
            if ($this->session->isSet('pay')) {
                //TODO: setOrderStatus($orderIds, ORDER_PAYED); //Оплачен заказ
            }
            if ($this->session->isSet('cancel')) {
                //TODO: setOrderStatus($orderIds, ORDER_CANCEL); //отмена заказа
            }
            if ($this->session->isSet('close')) {
                //TODO:setOrderStatus($orderIds, ORDER_CLOSED); //закрыть заказ как законченный
            }
            if ($this->session->isSet('delivery')) {
                //TODO:setOrderStatus($orderIds, ORDER_DELIVERED); //заказ доставлен
            }
        }

        if ($this->currentUser && $this->currentUser->getIsAdm()) {
            $this->redirect('/?c=order&a=manage');
        } else {
            $this->redirect('/?c=order');
        }
    }
}