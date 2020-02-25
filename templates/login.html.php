<?php require 'common/header.html.php'; ?>

<?php
$flashMessage = Util::getFlashMessage();
 if($flashMessage){ ?>
  <div id="flashMessage" class="alert alert-<?php echo $flashMessage['type']; ?> alert-dismissible fade show" role="alert">
  <?php echo $flashMessage['message']; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php }?>


<nav>
  <button class="btn btn-primary" id="login" onclick="{location.href='index.php?controller=auth&action=login'}">登录</button>
  <button class="btn btn-secondary " id="register" onclick="{location.href='index.php?controller=register&action=index'}">注册</button>
</nav>

<form id="loginForm" action="index.php?controller=auth&action=login" method="POST" >
  <div id="imformation">
    <div>
      <label class="label" for="username">账户：</label><br>
      <input type="text" id="username" name="username" placeholder=" 手机号/Email">
    </div>
    <div>
      <label class="label" for="password">密码: </label><br>
      <input type="password" id="password" name="password">
    </div>
    <input type="checkbox" class="checkbox">
    <label id="rememberMe">记住密码</label>
    <div>
      <input class="btn btn-primary shadow rounded" id="subtn" type="submit" value="登录">
    </div>
    <div>
      <a href="#">找回密码</a>&nbsp;|&nbsp;还没有注册账号？<a href="index.php?controller=register&action=index">立即注册</a>
    </div>
  </div>
</form>

<?php require 'common/footer.html.php'; ?>