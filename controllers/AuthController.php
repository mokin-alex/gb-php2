<?php

namespace app\controllers;

use app\models\User;
use app\services\Request;

class AuthController extends Controller
{
    public function actionLogin()
    {
        if ($this->currentUser) {
            $login_msg = $this->currentUser->getFirstName() . ", вы авторизованы!";
        } else {
            $login_msg = "Вы не авторизованы! Введите логин и пароль";
        }

        if (Request::isPost()) {
            $login = Request::cleanPost('login');
            $password = Request::cleanPost('password');
            $user = User::getUserByLogin($login);
            if ($user && $user->getPassword() == User::getHash($password)) {
                $this->session->set('user_id', $user->getId());
                if ($user->getIsAdm()) $this->redirect('/?c=auth&a=manage');
            }
            $this->redirect('/?c=auth&a=login');
        }

        echo $this->render('view_login', ['login_msg' => $login_msg]);
    }

    public function actionLogout()
    {
        $this->session->close();
        $this->redirect('/?c=auth&a=login');
    }

    public function actionManage()
    {
        if ($this->currentUser && $this->currentUser->getIsAdm()) {
            echo $this->render('view_manage');
        } else {
            $this->redirect('/?c=auth&a=login');
        }
    }
}