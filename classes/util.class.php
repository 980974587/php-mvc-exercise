<?php

/**
 * 工具类
 */
class Util
{

    /**
     * 页面刷新与转跳
     *
     * @param string $newUrl
     * @return void
     */
    function urlJump($newUrl)
    {
        header("Location: {$newUrl}");
        exit();
    }


    /**退出 */
    function logOut()
    {
        $_SESSION = array(); //清除SESSION值.
        if (isset($_COOKIE[session_name()])) {  //判断客户端的cookie文件是否存在,存在的话将其设置为过期.
            setcookie(session_name(), '', time() - 3600, '/');
        }
        session_destroy();  //清除服务器的session文件
    }

    
    /**
     * 生成页码
     *
     * @param [type] $totalCount
     * @param integer $perPageCount
     * @param integer $currentPage
     * @return void
     */
    function generatePaginator($totalCount, $perPageCount, $currentPage = 1)
    {

        $pageMax = ceil($totalCount / $perPageCount);
        $pages = [];

        if ($pageMax == 1) {
            return [
                'prev' => 'disable',
                'next' => 'disable',
                'pages' => [1],
                'currentPage' => $currentPage,
            ];
        } elseif ($pageMax <= 10) {
            for ($page = 1; $page <= $pageMax; $page++) {
                array_push($pages, $page);
            }
        } else {
            if ($currentPage <= 5) {
                for ($page = 1; $page <= 5; $page++) {
                    array_push($pages, $page);
                }
                array_push($pages, '...');
            } elseif (5 < $currentPage && $currentPage < ($pageMax - 4)) {
                $pages = [
                    1, 2, '...', $currentPage - 2, $currentPage - 1,
                    $currentPage, $currentPage + 1, $currentPage + 2, '...',
                    $pageMax - 1, $pageMax
                ];
            } else {
                $pages = [1, 2, '...',];
                for ($i = $pageMax - 4; $i <= $pageMax; $i++) {
                    array_push($pages, $i);
                }
            }
        }

        return [
            'prev' => 'enable',
            'next' => 'enable',
            'pages' => $pages,
            'currentPage' => $currentPage,
        ];
    }


    /**
     * 判断消息提示类型
     *
     * @param string $type
     * @param string $message
     * @return void
     */
    function setFlashMessage($type, $message)
    {
        if (!in_array($type, ['danger', 'success'])) {
            return;
        }
        $_SESSION['flashMessage'] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    /**
     * 得到消息提示的内容
     *
     * @return array
     */
    function getFlashMessage()
    {
        if (empty($_SESSION['flashMessage'])) {
            return null;
        }
        $message =  $_SESSION['flashMessage'];
        unset($_SESSION['flashMessage']);

        return $message;
    }


    /*-----------\（#-#）/新函数分隔大法\（#-#）/------------*/



    /**
     * ===========================
     * 配置读取函数
     * ===========================
     */

    /**
     * 读取指定键名配置的值
     *
     * 注意：需在 includes 目录下创建 config.php 文件，每个PHP页面入口文件头部引用此文件，内容为：
     * <?php
     * return [
     *     'userDataFilePath' => dirname(__DIR__) . '/users.txt',
     * ];
     *
     * @param string $key
     * @return mixed|null
     */
    function getConfig($key)
    {
        $_CFG = require 'includes/config.php';
        // 	global $_CFG;
        return $this->getValueFromArray($_CFG, $key);
    }

    /**
     * 从指定数组中获取指定键名的值，如果键名为 NULL，则返回 NULL
     *
     * @param array $array
     * @param string $key
     * @return mixed|null
     */
    function getValueFromArray($array, $key = null)
    {
        if ($key == null) {
            return $array;
        }
        return isset($array[$key]) ? $array[$key] : null;
    }

    /**
     * ===========================
     * $_GET、$_POST、数组操作函数
     * ===========================
     */

    /**
     * 获取 $_POST 中指定键名的值，如果键名为 NULL，则返回 $_POST 数组
     *
     * @param string $key
     * @return mixed|null
     */
    function getPost($key = null)
    {
        return $this->getValueFromArray($_POST, $key);
    }

    /**
     * 获取 $_GET 中指定键名的值，如果键名为 NULL，则返回 $_GET 数组
     *
     * @param string $key
     * @return mixed|null
     */
    function getQuery($key = null)
    {
        return $this->getValueFromArray($_GET, $key);
    }

    
}
