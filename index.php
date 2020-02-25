<?php
require 'classes/util.class.php';
require 'classes/user-model.class.php';
require 'classes/validate.class.php';

// 登陆页：index.php?controller=auth&action=login
// 退出：index.php?controller=auth&action=logout
// 注册页：index.php?controller=register&action=index
// 注册检查用户名与邮箱：index.php?controller=register&action=checkExisted
// 用户管理页：index.php?controller=user&action=index
// 添加用户模态框：index.php?controller=user&action=addModal
// 用户详情模态框：index.php?controller=user&action=detailModal
// 编辑用户模态框：index.php?controller=user&action=editModal
// 删除用户：index.php?controller=user&action=delete
// 我的设置页：index.php?controller=my&action=settings

/**
 * 自定义异常
 *
 * @param [type] $exception
 * @return void
 */
function  globalException($exception)
{
    $util=new Util();
    $util->setFlashMessage("danger",$exception->getMessage());
    if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(["status" => "dataError", "message" => $exception->getMessage()]);
        exit();
    }
    $util->urlJump("index.php?controller=user&action=index");
}
set_exception_handler("globalException");

session_start();
require 'classes/' . $_GET["controller"] . '-controller.class.php';
$controllerName = $_GET["controller"] . "Controller";
$actionName = $_GET["action"] . "Action";

$controller = new $controllerName();
$controller->$actionName();
