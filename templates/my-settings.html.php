<?php require 'common/header.html.php'; ?>

<div id="errorMessageDiv" class="alert alert-primary alert-dismissible fade show" role="alert">
  <label class="showErrorMessage"></label>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<?php 
$flashMessage = $util->getFlashMessage();
if($flashMessage){ ?>
  <div id="flashMessage" class="alert alert-<?php echo $flashMessage['type']; ?> alert-dismissible fade show" role="alert">
  <?php echo $flashMessage['message']; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php }?>


<form id="editForm" action="index.php?controller=my&action=settings" method="POST">
  <div id="imformation">
    <h5 class="formTitle text-primary font-weight-bold">我的设置</h5>
    <p>
      <label for="username">用户名：</label><br>
      <input type="text" class="input controltName form-controlt" id="editUsername" name="username" disabled placeholder=" 4-16字符，允许中英文(中文算2字符）、数字" value="<?php echo $user['username']; ?>">
    </p>
    <p>
      <label for="trueName">真实姓名: </label><br>
      <input type="text" class="input" id="editTrueName" name="truename" value="<?php echo $user['truename']; ?>">
    </p>
    <p>
      <label for="email">电子邮箱: </label><br>
      <input type="email" class="input" id="editEmail" name="email" value="<?php echo $user['email']; ?>">
    </p>
    <p>
      <label for="age">年龄: </label><br>
      <input type="text" class="input" id="editAge" name="age" value="<?php echo $user['age']; ?>">
    </p>
    <p class="radio">
      <label for="job">职业: </label><br>
      <input type="radio" id="student" value="student" name="job" <?php if ($user['job'] == "student") echo "checked"; ?>>
      <label class="editJobRadio">学生</label>
      <input type="radio" id="worker" value="worker" name="job" <?php if ($user['job'] == "worker") echo "checked"; ?>>
      <label class="editJobRadio">上班族</label>
    </p>
    <p>
      <label for="schoolOrCompany">学校: </label><br>
      <input type="text" class="input" id="schoolOrCompany" name="schoolOrCompany" value="<?php echo $user['schoolOrCompany']; ?>">
    </p>
    <p class="checkbox">
      <label for="hobby">兴趣爱好: </label><br>
      <input type="checkbox" value="绘画" name="hobby[]" <?php if(isset($hobbyList) && in_array("绘画", $hobbyList)) echo "checked";?>>
      <label class="editHobby">绘画</label>
      <input type="checkbox" value="音乐" name="hobby[]" <?php if(isset($hobbyList) && in_array("音乐", $hobbyList)) echo "checked"; ?>>
      <label class="editHobby" >音乐</label>
      <input type="checkbox" value="粘土" name="hobby[]" <?php if(isset($hobbyList) && in_array("粘土", $hobbyList)) echo "checked"; ?>>
      <label class="editHobby">粘土</label>
      <input type="checkbox" value="学习" name="hobby[]" <?php if(isset($hobbyList) && in_array("学习", $hobbyList)) echo "checked"; ?>>
      <label class="editHobby">学习</label>
      <input type="checkbox" value="摸鱼" name="hobby[]" <?php if(isset($hobbyList) && in_array("摸鱼", $hobbyList)) echo "checked"; ?>>
      <label class="editHobby">摸鱼</label>
      <input type="checkbox" value="划水" name="hobby[]" <?php if(isset($hobbyList) && in_array("划水", $hobbyList)) echo "checked"; ?>>
      <label class="editHobby">划水</label>
    </p>
    <p>
      <input class="btn btn-primary shadow rounded" id="add" type="submit" value="保存">
    </p>
  </div>
</form>

<?php require 'common/footer.html.php'; ?>