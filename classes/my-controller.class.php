<?php

class MyController
{
    public function settingsAction()
    {
        $util=new Util();
        $user=new UserModel();
        $htmlTitle = '我的设置';
        //判断用户是否登录，如果未登陆，则跳转到 index.php?controller=auth&action=login
        if (!isset($_SESSION["id"])) {
            header("location:index.php?controller=auth&action=login");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // @todo 校验数据，如果非法，则在页面的头部显示 "数据格式不正确，更新个人资料失败！"。
        
            //保存用户信息。
          $editID = $user->getUserByUsername($_SESSION["username"])['id'];
          if (!$user->updateUser($editID, $_POST)) {
            $util->setFlashMessage('danger','保存用户数据失败');
          }else{
            $util->setFlashMessage('success','更新用户资料成功');
            }
            $util->urlJump("index.php?controller=my&action=settings");
            
        } else {
            $user = $user->getUserById($_SESSION['id']);
            $hobbyList = explode(",", $user['hobby']);
            require 'templates/my-settings.html.php';
        }
        
    }
}