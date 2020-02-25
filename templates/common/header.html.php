<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo isset($htmlTitle) ? $htmlTitle : '标题被吃了!' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="includes/css/bootstrap.min.css" rel="stylesheet">
  <link href="static/css/main.css" rel="stylesheet" type="text/css" media="screen" />
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="includes/js/jquery.validate.js"></script>
  <script src="includes/js/bootstrap.bundle.min.js"></script>
  <script src="includes/js/bootstrap.bundle.js"></script>
  <script src="includes/js/bootstrap.min.js"></script>
  <script src="static/js/main.js"></script>
  <!-- 如果将项目css全部导入容易引起变量和命名冲突问题 -->
  <?php
  switch ($htmlTitle) {
    case '登录': ?>
    <link href="static/css/login.css" rel="stylesheet" type="text/css">
    <script src="static/js/login.js"></script>
    <?php
    break;
  case '注册': ?>
    <link href="static/css/register.css" rel="stylesheet" type="text/css">
    <script src="static/js/register.js"></script>
    <?php
    break;
  case '用户管理': ?>
    <link href="static/css/admin.css" rel="stylesheet" type="text/css">
    <script src="static/js/admin.js"></script>
    <?php
    break;
  case '我的设置': ?>
    <link href="static/css/my-settings.css" rel="stylesheet">
    <script src="static/js/my-settings.js"></script>
    <?php
    break;
} ?>
</head>

<body>

  <!-- 头部 -->
  <div class="head">
    <h3 class="logo mr-3 float-left font-weight-bold text-light" id="logo"><a class="text-light" href="index.php?controller=user&action=index">BootCamp</a></h3>
    <nav class="navbar loginedMessage w-25  navbar-light  float-left shadow rounded">
      <a class="navbar-nav w-25 text-center text-white" href="index.php?controller=user&action=index">用户&nbsp;&nbsp;</a><span class="text-light">|</span>
      <a class="navbar-nav w-25 text-center text-white" href="#">讨论区&nbsp;</a><span class="text-light">|</span>
      <a class="navbar-nav w-25 text-center text-white" id="setting" href="index.php?controller=my&action=settings">我的设置</a>
    </nav>
    <span class="loginMessage float-right  pr-3 text-light">
      <a class="text-light mr-2" href="index.php?controller=auth&action=login">登录</a>
      <a class="text-light mr-2" href="index.php?controller=register&action=index">注册</a>
    </span>
    <span class="loginedMessage loginedRight float-right text-light">
      <span id="exit"><?php echo isset($_SESSION["username"]) ? "你好，" . $_SESSION["username"] : "" ?></span>
      <a class="ml-3" href="index.php?controller=auth&action=logout">退出</a>
    </span>
  </div>