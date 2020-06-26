<?php

namespace app\controllers;

use app\models\repositories\UserRepository;
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
        $request = new Request();
        if ($request->isPost()) {
            $login = $request->cleanPost('login');
            $password = $request->cleanPost('password');
            $user = (new UserRepository())->getUserByLogin($login);
            if ($user && $user->getPassword() == User::getHash($password)) {
                $this->session->set('user_id', $user->getId());
                if ($user->getIsAdm()) $this->redirect('/auth/manage');
            }
            $this->redirect('/auth/login');
        }

        echo $this->render('view_login', ['login_msg' => $login_msg]);
    }

    public function actionLogout()
    {
        $this->session->close();
        $this->redirect('/auth/login');
    }

    public function actionManage()
    {
        if ($this->currentUser && $this->currentUser->getIsAdm()) {
            echo $this->render('view_manage');
        } else {
            $this->redirect('/auth/login');
        }
    }
}