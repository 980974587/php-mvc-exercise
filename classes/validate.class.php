<?php

/**
 * 信息验证类
 */
class Validate
{
    /**
     * 校验注册表单的正确性
     *
     * @param array $imformationArray
     * @return void
     */
    function checkRegisterImformation(array $imformationArray)
    {
        if (!$this->validateUsername($imformationArray['username']) || !$this->validateLength($imformationArray['username'], 4, 16, "chinese")) {
            throw new Exception("输入的用户名格式错误");
        }

        if (!$this->validateEmail($imformationArray['email'])) {
            throw new Exception("输入的邮箱格式错误");
        }

        if (!$this->validatePassword($imformationArray['password'])) {
            throw new Exception("输入的密码格式错误");
        }
        //todo:待改正再启用
        /*             if (!$this->validateTruename($imformationArray['truename'])) {
                throw new Exception("注册输入的信息格式错误");
            } */

        if (!$this->validateAge($imformationArray['age'])) {
            throw new Exception("输入的年龄格式错误");
        }

        return true;
    }


    /**
     * ===========================
     * 通用校验函数
     * ===========================
     */


    //TODO：改正则匹配待改正
    /**
     * 检查是否是中文
     *
     * @param [type] $value
     * @return void
     */
    function validateChinese($value)
    {
        /**姓名只能是中文 */
        if (!empty($text) && preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $value)) {
            return true;
        }
        return false;
    }

    /** 
     * 校验长度
     *
     */
    function validateLength($text, $minlength, $maxlength, $type)
    {
        if ($type == 'chinese') {
            //一个中文算一个字符
            $length = iconv_strlen($text, "UTF-8");
            if (!empty($text) && $length >= $minlength && $length <= $maxlength) {
                return true;
            } else {
                return false;
            }
        } else {
            $lengthUtf8 = strlen($text);
            $lengthWord = iconv_strlen($text, "UTF-8");
            $length = ($lengthUtf8 - $lengthWord) / 2 + $lengthWord;
            if (!empty($text) && $length >= $minlength && $length <= $maxlength) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * ===========================
     * 用户字段校验函数
     * ===========================
     */

    function validateUsername($username)
    {
        if (!empty($username) && preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/u', $username)) {
            return true;
        }
        return false;
    }

    function validateEmail($email)
    {
        if (!empty($email) && preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/", $email)) {
            return true;
        }
        return false;
    }

    function validatePassword($password)
    {
        if (!empty($password) && preg_match("/^[a-z_A-Z0-9-\.!@#\$%\\\^&\*\)\(\+=\{\}\[\]\/,'<>~\·`\?:;]+$/", $password)) {
            return true;
        }
        return false;
    }

    function validateTruename($truename)
    {
        if ($this->validateChinese($truename) && $this->validateLength($truename, 2, 5, 'chinese')) {
            return true;
        } else {
            return false;
        }
    }

    function validateAge($age)
    {
        if (!empty($age) && preg_match("/^1$|^100$|^[1-9]\d{1}$/", $age)) {
            return true;
        } else {
            return false;
        }
    }

    function validateSchoolOrCompany($schoolOrCompany)
    {
        return $this->validateLength($schoolOrCompany, 1, 100, "chinese");
    }
}
