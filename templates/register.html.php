<?php require 'common/header.html.php'; ?>

<div id="errorMessageDiv" class="alert alert-primary alert-dismissible fade show" role="alert">
  <label class="showErrorMessage"></label>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<?php
$flashMessage = Util::getFlashMessage();
 if($flashMessage){ ?>
  <div id="flashMessage" class="alert alert-<?php echo $flashMessage['type']; ?> alert-dismissible fade show" role="alert">
  <?php echo $flashMessage['message']; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>

<div class="formTitle">
  <button class="btn btn-secondary " id="login" onclick="{location.href='index.php?controller=auth&action=login'}">登录</button>
  <button class="btn btn-primary" id="register" onclick="{location.href='index.php?controller=register&action=index'}">注册</button>
</div>

<form id="registerForm" action="index.php?controller=register&action=index" method="post">
  <div id="registerImformation">
    <div>
      <label for="username">用户名：</label><br>
      <input type="text" class="input" id="username" name="username" placeholder=" 4-16字符，允许中英文(中文算2字符）、数字">
    </div>
    <div>
      <label for="password">密码: </label><br>
      <input type="password" class="input" id="password" name="password" placeholder=" 6-18字符，允许英文、数字、符号">
    </div>
    <div>
      <label for="confirm-password">确认密码: </label><br>
      <input type="password" class="input" id="confirm-password" name="confirm-password" placeholder=" 请重复密码">
    </div>
    <div>
      <label for="truename">真实姓名: </label><br>
      <input type="text" class="input" id="truename" name="truename">
    </div>
    <div>
      <label for="email">电子邮箱: </label><br>
      <input type="email" class="input" id="email" name="email">
    </div>
    <div>
      <label for="age">年龄: </label><br>
      <input type="text" class="input" id="age" name="age">
    </div>
    <div class="radio">
      <label for="job">职业: </label><br>
      <div class="jobRadio float-left mr-2">
        <input type="radio" value="student" name="job" checked>
        <label for="student">学生</label>
      </div>
      <div class="jobRadio mr-2">
        <input type="radio" value="worker" name="job">
        <label for="worker">上班族</label>
      </div>
      <div>
        <label class='schoolOrCompany' for="schoolOrCompany">学校: </label><br>
        <input type="text" class="input" id="schoolOrCompany" name="schoolOrCompany">
      </div>
      <div class="checkbox">
        <label for="hobby">兴趣爱好: </label><br>
        <input type="checkbox" value="绘画" name="newhobby">
        <label class="addHobby">绘画</label>
        <input type="checkbox" value="音乐" name="newhobby">
        <label class="addHobby">音乐</label>
        <input type="checkbox" value="粘土" name="newhobby">
        <label class="addHobby">粘土</label>
        <input type="checkbox" value="学习" name="newhobby">
        <label class="addHobby">学习</label>
        <input type="checkbox" value="摸鱼" name="newhobby">
        <label class="addHobby">摸鱼</label>
        <input type="checkbox" value="划水" name="newhobby">
        <label class="addHobby">划水</label>
      </div>
      <div>
        <input class="btn btn-primary shadow rounded" id="add" type="submit" value="注册">
      </div>

    </div>

</form>




<?php require 'common/footer.html.php'; ?>