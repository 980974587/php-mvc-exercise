<?php
class RegisterController
{
    public function indexAction()
    {
        $util=new Util();
        $user=new UserModel();
        $validate=new Validate();
        $htmlTitle = "注册";
        if (isset($_SESSION["id"])) {
            header("location:index.php?controller=user&action=index");
        }

        // 通过表单的 POST 方式提交数据
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // 校验数据，如果非法，则在页面的头部区域显示"数据格式不正确，注册失败！"的错误提示。	
            if (!$validate->checkRegisterImformation($_POST)) {
                setFlashMessage("danger", "数据格式不正确，注册失败！");
                urlJump("index.php?controller=register&action=index");
            }

            // 如果保存成功，则 跳转到 index.php?controller=user&action=index 页面，并在 index.php?controller=user&action=index 页面的头部区域显示"恭喜您，注册成功！"
            $returnMessage = $user->createUser($_POST);

            if ($returnMessage['ok']) {
                $util->setFlashMessage("success", "恭喜你，注册成功！");
                $newUser = $returnMessage['newUser'];
                $_SESSION['id'] = $newUser['id'];
                $_SESSION["username"] = $newUser['username'];
                $_SESSION["role"] = $newUser['role'];
            }

            echo json_encode($returnMessage);
            exit();
        } else {
            require 'templates/register.html.php';
        }
    }

    public function checkExistedAction()
    {
        // 校验数据，如果非法，则在页面的头部区域显示"数据格式不正确，注册失败！"的错误提示。

        $user=new UserModel();
        $util=new Util();
        if ($util->getQuery('username')) {
            if ($user->isUsernameExist($util->getQuery('username'))) {
                echo json_encode(["status" => "error", "message" => "用户名已被占用!"]);
                exit();
            }
        }

        if ($util->getQuery('email')) {
            if ($user->isEmailExist($util->getQuery('email'),$util->getQuery("id"))) {
                echo json_encode(["status" => "error", "message" => "邮箱已被占用!"]);
                exit();
            }
        }

        echo json_encode(["status" => "success"]);
        exit();
    }
}
