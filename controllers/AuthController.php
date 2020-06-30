<?php

namespace app\controllers;

use app\models\repositories\UserRepository;
use app\models\User;

class AuthController extends Controller
{
    public function actionLogin()
    {

        if ($this->request->isPost()) {
            $login = $this->request->cleanPost('login');
            $password = $this->request->cleanPost('password');
            $user = (new UserRepository())->getUserByLogin($login);
            if ($user && $user->getPassword() == User::getHash($password)) {
                $this->session->set('user_id', $user->getId());
                if ($user->getIsAdm()) {
                    $this->redirect('/auth/manage');
                }
            }
            $this->redirect('/auth/login');
        }
        echo $this->render('view_login', ['user' => $this->currentUser]);
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