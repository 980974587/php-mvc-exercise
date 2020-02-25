<?php

require 'classes/user-model.class.php';
require 'classes/util.class.php';
require 'classes/validate.class.php';

/* $oldLines = '2|12342|123456|成员|卡卡|12@qq.com|22|学生|22|绘画|'; */



/* $user=new UserModel();
var_dump($user->isEmailExist("13@qq.com",3)); */

/* $validate=new Validate();
var_dump($validate->validateTruename("哒啊哈"));
 */


    var_dump(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');

