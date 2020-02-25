<?php

class AuthController
{
    public function loginAction()
    {
        $util=new Util();
        $user=new UserModel();
        $htmlTitle = '登录';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user=$user->getUserByUsername($util->getPost('username'));
            if($user['password']==md5($util->getPost('password')))
            {
                $_SESSION["id"] = $user['id'];
                $_SESSION["username"] = $user['username'];
                $_SESSION["role"] = $user['role'];
                $util->urlJump("index.php?controller=user&action=index");
            }
            $util->setFlashMessage("danger", "用户名或密码不正确！");
            $util->urlJump('index.php?controller=auth&action=login');
        } else {
            if (!empty($_SESSION["id"])) {
                $util->urlJump("index.php?controller=user&action=index");
            }
            require 'templates/login.html.php';
        }
        
    }

    public function logoutAction()
    {
        $util=new Util();
        $util->logOut();
        $util->urlJump("index.php?controller=auth&action=login");
    }
}