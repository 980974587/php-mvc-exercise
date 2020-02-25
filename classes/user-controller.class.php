<?php


class UserController
{
    public function indexAction()
    {
        $util = new Util();
        $user = new UserModel();
        $htmlTitle = '用户管理';
        if (empty($_SESSION["id"])) {
            header("location:index.php?controller=auth&action=login");
        }
        $queryKey = [];

        //查询，默认选择全部职业
        if ($util->getQuery('jobKey')) {
            $queryKey['job'] = $util->getQuery('jobKey');
        }
        if ($util->getQuery('keyWord')) {
            $queryKey[$util->getQuery('keyName')] = $util->getQuery('keyWord');
        }

        $pageMax = ceil($user->countUsers($queryKey) / 10);


        if ($util->getQuery('page')) {
            switch ($util->getQuery('page')) {
                case -1:
                    break;
                case 0:
                    $page = 1;
                    break;
                case $pageMax + 1:
                    $page = $pageMax;
                    break;
                default:
                    $page = $util->getQuery('page');
                    break;
            }
        } else {
            $page = 1;
        }

        $users = $user->searchUsers($queryKey, "", ($page - 1) * 10, 10);
        //如果没有查询到记录就不显示页码
        if (empty($users)) $page = -1;
        if ($page > 0) {
            $pages = $util->generatePaginator($user->countUsers($queryKey), 10, $page);
        }

        require 'templates/users.html.php';
    }


    public function addModalAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //判断是否登录
            if (!isset($_SESSION["id"])) {
                $result = ["status" => "unlogin"];
                exit(json_encode($result));
            }

            //判断是否为管理员
            if ($_SESSION["role"] != "admin") {
                $result = ["status" => "forbidden"];
                exit(json_encode($result));
            }

            $util = new Util();
            $user = new UserModel();
            $validate=new Validate();
            // 验证数据是否合法
            $checkResule = $validate->checkRegisterImformation($_POST);
            if (!$checkResule) {
                setFlashMessage("danger", "数据格式不正确，注册失败！");
                urlJump("index.php?controller=user&action=index");
            }


            $result = $user->createUser($_POST);

            if ($result['ok']) {
                $util->setFlashMessage("success", "添加用户成功");
                $result = ["status" => "success"];
            } else {
                $result = ["status" => "error", "message" => "保存新用户失败"];
            }
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode($result);
            exit();
        } else {
            //判断是否为管理员，如果不是，则在输出的模态框中显示“您无权操作！"的错误提示。
            //如果是，则在模态框中，显示添加新用户的表单。
            $result = ["status" => "success"];
            if ($_SESSION["role"] != "admin") {
                $result = ["status" => "forbidden"];
            }
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode($result);
        }
    }


    public function editModalAction()
    {

        $util = new Util();
        $user = new UserModel();
        $result = ["status" => "ok"];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            // @todo: 校验数据，如果非法，则输出JSON {"status": "error", "message": "数据格式不正确！"}，前端收到此回应后，在模态框的头部区域显示此错误消息。
            /*   if (!validateChinese($registerImformation)) {
		    setFlashMessage("danger", "数据格式不正确，注册失败！");
		    urlJump("index.php?controller=register&action=index");
	        } */


            //保存用户信息。
            $editID = $user->getUserByUsername($util->getPost('username'))['id'];

            if (!$user->updateUser($editID, $_POST)) {
                $result = ["status" => "error", "message" => "保存用户信息失败！"];
            } else {
                $util->setFlashMessage('success', '编辑用户成功');
            }
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode($result);
        } else {
            // 判断是否为管理员，如果不是，则在输出的模态框中，用 `alert-danger`组件显示“您无权操作！"的错误提示。
            if ($_SESSION["role"] != "admin") {
                $result = ["status" => "forbidden"];
                exit(json_encode($result));
            }

            $getUser = $user->getUserById($util->getQuery('id'));
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode($getUser);
        }
    }

    public function detailModalAction()
    {
        $util = new Util();
        $user = new UserModel();
        header('Content-Type:application/json; charset=utf-8');

        $getUser = $user->getUserById($util->getQuery('id'));

        echo json_encode($getUser);
    }

    public function deleteAction()
    {
        header('Content-Type:application/json; charset=utf-8');
        $result = ["status" => "success"];
        $filename = "users/users.txt";

        $util = new Util();
        $user = new UserModel();

        // 如果非 POST 提交，那么则直接返回错误信息
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode([
                "status" => "error",
                "message" => "请用POST提交!",
            ]);
            exit();
        }


        // 判断是否为管理员
        if ($_SESSION["role"] != "admin" || $_SESSION["id"] == $_POST['id']) {
            $result = ["status" => "forbidden"];
            exit(json_decode($result));
        }

        //如果是，则删除数据
        if ($user->deleteUser($util->getPost('id'))) {
            $result = ["status" => "success"];
        };
        exit(json_encode($result));
    }
}
