<?php

class UserModel
{

	/**
	 * 检查读写文件权限
	 *
	 * @param string $filename
	 * @return boolean
	 */
	function checkPermission($filename)
	{
		$getPermission = true;
		//不存在则创建
		if (!file_exists($filename)) {
			fopen($filename, 'a');
		}
		//先检查读写权限
		if (!fopen($filename, "a")) {
			$getPermission = false;
			exit("不能打开文件 $filename");
		}
		if (!fopen($filename, "a+")) {
			$getPermission = false;
			exit("不能写入文件 $filename");
		}
		return $getPermission;
	}

	

	/**
     * ===========================
     * 文件操作相关函数
     * ===========================
     */


    /**
     * 向文件末尾写入一行文本
     *
     * @param string $filepath
     * @param string $line
     * @return boolean 是否写入成功
     */
    function writeLineToFile($filepath, $line)
    {
        $handle = fopen($filepath, "a+");
        //如果存入的是空的内容就不能用！直接判断
        if (fwrite($handle, $line . PHP_EOL) != false) {
            fclose($handle);
            return true;
        }
        fclose($handle);
        return false;
    }

    /**
     * 从文件读取最后一行文本
     *
     * @param string $filepath
     * @return string
     */
    function getLastLineFromFile($filepath)
    {
        $handle = fopen($filepath, "r");
        fseek($handle, -1, SEEK_END);
        $lastLine = '';
        while (($c = fgetc($handle)) !== false) {
            if ($c == PHP_EOL && $lastLine) break;
            $lastLine = $c . $lastLine;
            fseek($handle, -2, SEEK_CUR);
        }
        fclose($handle);
        return $lastLine;
    }

    /**
     * 从文件读取所有行写入数组，每一行为数组中的一个值
     *
     * @param string $filepath
     * @return array
     */
    function getAllLinesFromFile($filepath)
    {
/*         if (!checkPermission($filepath)) {
            //TODO：抛出异常
        } */
        $handle = fopen($filepath, "r");
        $getLines = array();

        while (!feof($handle)) {
            $line = fgets($handle); //fgets()函数从文件指针中读取一行
            //不同系统换行符号不同，取出时要替换不同系统写入的换行符
            $line = str_replace("\n", '', $line);
            $line = str_replace("\r", '', $line);
            $line = str_replace("\r\n", '', $line);
            if ($line == '') {
                continue;
            }
            array_push($getLines, $line);
        }
        fclose($handle);
        return $getLines;
    }

	/**
     * ===========================
     * 用户查询函数
     * ===========================
     */

    function getUserById($id)
    {
        return $this->getUserByField('id', $id);
    }

    function getUserByUsername($username)
    {
        return $this->getUserByField('username', $username);
    }

    function getUserByEmail($email)
    {
        return $this->getUserByField('email', $email);
    }


    /**
     * 根据关键字准确查询
     *
     * @param string $name
     * @param string $value
     * @return array 
     */
    function getUserByField($name, $value)
    {
		$util=new Util();
        $users = $this->getAllLinesFromFile($util->getConfig('userDataFilePath'));
        foreach ($users as $user) {
            $user = $this->unserializeUser($user);
            if ($user[$name] == $value) {
                return $user;
            }
        }

        return false;
    }


    function isUsernameExist($username)
    {
        if ($this->getUserByField('username', $username)) {
            return true;
        }
        return false;
    }

    /**
     * 判断查重
     *
     * @param [type] $email
     * @param [type] $id
     * @return boolean
     */
    function isEmailExist($email, $id = null)
    {
        //如果没有修改过内容就不用判断重复
        if ($id>=0) {
            if ($this->getUserByField('id', $id)['email'] == $email) {
                return false;
            }
        }

        if ($this->getUserByField('email', $email)) {
            return true;
        }
        return false;
    }


    /**
     * 搜索用户
     */

    function searchUsers($conditions, $orderBy, $start, $limit)
    {
        $users = $this->unserializeUsers();

        $users = $this->filterCollectionByConditions($users, $conditions, $start, $limit);

        return $users;
    }


    //统计用户数
    function countUsers($conditions)
    {
        $users = $this->unserializeUsers();

        $usersResult = $this->filterCollectionByConditions($users, $conditions, 0, count($users));

        return count($usersResult);
    }


	/**
     * ===========================
     * 集合操作函数
     * ===========================
     */


    /**
     * 根据 $conditions 中的条件，过滤集合数据
     * 
     * 比如，过滤角色为学生，Email地址为 abc@example.com 的用户集合
     * 
     * $users = filterCollectionByConditions($users, ['role' => 'student', 'email' => 'abc@example.com'], 0, 10);
     * 
     *
     * @param array $collection
     * @param array $conditions
     * @param int $start 开始记录行数
     * @param int $limit 最多返回的行数
     * @return void
     */
    function filterCollectionByConditions($collection, $conditions, $start, $limit)
    {
        $result = [];
        $matchNumber = 0;

        //如果没有过滤条件直接截取并返回
        if (empty($conditions)) {
            return array_slice($collection, $start, $limit);
        }

        foreach ($collection as $thisCollection) {

            foreach ($conditions as $key => $value) {
                if (strpos($thisCollection[$key], $value) !== false) {
                    $matchNumber++;
                }
            }

            //如果匹配次数等于条件长度，即符合所有条件
            if ($matchNumber == count($conditions)) {
                array_push($result, $thisCollection);
            }
            //清空匹配次数
            $matchNumber = 0;
        }

        return array_slice($result, $start, $limit);
    }

    /**
     * ===========================
     * 用户操作函数
     * ===========================
     */

    function createUser($user)
    {
        $util=new Util();
        $validate=new Validate();

        $newUser = [];
        $newUser['id'] = $this->generateNextUserId();
        $role = 'member';
        if ($newUser['id'] == 1) {
            $role = 'admin';
        }
        $newUser['role'] = $role;
        $newUser['job'] = $util->getValueFromArray($user, 'job');
        $newUser['hobby'] = $util->getValueFromArray($user, 'hobby');

        $username = $util->getValueFromArray($user, 'username');
        if (!$validate->validateUsername($username)) {
            return ['ok' => false, 'message' => '用户名格式不正确'];
        }

        if ($this->isUsernameExist($username)) {
            return ['ok' => false, 'message' => "用户名已存在"];
        }
        $newUser['username'] = $username;

        $email = $util->getValueFromArray($user, 'email');
        if (!$validate->validateEmail($email)) {
            return ['ok' => false, 'message' => '邮件格式不正确'];
        }
        if ($this->isEmailExist($email)) {
            return ['ok' => false, 'message' => '邮件地址已存在'];
        }
        $newUser['email'] = $email;

        $password = $util->getValueFromArray($user, 'password');
        if (!$validate->validatePassword('password')) {
            return ['ok' => false, 'message' => '密码格式不正确'];
        }
        $newUser['password'] = md5($password);

        $truename = $util->getValueFromArray($user, 'truename');
        //真实姓名验证有问题
        /* 	if(!validateTruename('truename'))
	{
		return ['ok'=>false,'message'=>'真实姓名格式不正确'];
	} */
        $newUser['truename'] = $truename;

        $age = $util->getValueFromArray($user, 'age');
        /* 	if (!validateAge('age')) {
		return ['ok' => false, 'message' => '年龄格式不正确'];
	} */
        $newUser['age'] = $age;

        $schoolOrCompany = $util->getValueFromArray($user, 'schoolOrCompany');
        //验证待补齐
        /* 	if (!validateSchoolOrCompany('schoolOrCompany')) {
		return ['ok' => false, 'message' => '学校或者公司格式不正确'];
	} */
        $newUser['schoolOrCompany'] = $schoolOrCompany;

        $line = $this->serializeUser($newUser);

        $writed = $this->writeLineToFile($util->getConfig('userDataFilePath'), $line);

        if (!$writed) {
            return ['ok' => false, 'message' => '保存用户到数据文件失败'];
        }
        return ['ok' => true, 'newUser' => $newUser];
    }

    /**
     * 更新用户信息
     *
     * @param int $id
     * @param array $user(一维、索引)
     * @return boolean
     */
    function updateUser($id, $user)
    {
		$util=new Util();
        //TODO:测试
        if (!$this->getUserById($id)) {
            return ["ok" => false];
        }
        $oldUser = $this->getUserById($id);
        $newUser = $oldUser;
        /* 	$user['id'] = $id; */

        foreach ($user as $key => $value) {
            $newUser[$key] = Util::getValueFromArray($user, $key);
        }

        /* 	if (!Util::getValueFromArray($user, 'role')) {
		$user['role'] = $oldUser['role'];
	}
	if (!Util::getValueFromArray($user, 'username')) {
		$user['username'] = $oldUser['username'];
	} 
	$user['password'] = $oldUser['password'];*/

        /* 	$editKeys = getConfig('editKeys');
	foreach ($editKeys as $key) {
		$user[$key] = Util::getValueFromArray($user, $key);
	} */
        $oldUser = $this->serializeUser($oldUser);
        $newUser = $this->serializeUser($newUser);

        //根据旧数据查找该记录下标并替换该记录
        $users = $this->getAllLinesFromFile($util->getConfig('userDataFilePath'));
        $users[array_search($oldUser, $users)] = $newUser;

        return $this->writeAllToFile($util->getConfig('userDataFilePath'), $users);
    }

    //返回序列化的循环键值
    function getUserKeys()
    {
        return ['id', 'username', 'password', 'role', 'truename', 'email', 'age', 'job', 'schoolOrCompany', 'hobby'];
    }

    function deleteUser($id)
    {
		$util=new Util();
        $oldUser = $this->getUserById($id);
        $oldUser = $this->serializeUser($oldUser);
        $users = $this->getAllLinesFromFile($util->getConfig('userDataFilePath'));
        array_splice($users, array_search($oldUser, $users), 1);

        return $this->writeAllToFile($util->getConfig('userDataFilePath'), $users);
    }

    /**
     * 将用户数组序列化成一行文本，以便于可以写入文件
     *
     * @param array $user
     * @return string
     */
    //TODO：测试
    function serializeUser($user)
    {
        //外部取值就先判断是否为空再调用此函数
        $userLine = '';
        $keys = $this->getUserKeys();
        foreach ($keys as $key) {
            if (is_array($user[$key])) {
                $user[$key] = implode(',', $user[$key]);
            }
            $userLine .= $user[$key] . "|";
        }
        return $userLine;
    }

    /**
     * 将一行文本反序列化为用户数组
     *
     * @param string $line
     * @return array
     */
    function unserializeUser($line)
    {
        $line = explode("|", $line);
        //分割出来的最后一个元素空，剔除
        array_pop($line);

        $keys = $this->getUserKeys();

        return array_combine($keys, $line);
    }

    /**
     * 生成下一个用户ID
     *
     * @return int
     */
    function generateNextUserId()
    {
		$util=new Util();

        $userLine = $this->getLastLineFromFile($util->getConfig('userDataFilePath'));

        if (empty($userLine)) {
            return 1;
        }
        $user = $this->unserializeUser($userLine);

        return $user['id'] + 1;
    }

    /**
     * 写入所有数据到文本文件，要求数组元素是文本
     *
     * @param string $filepath
     * @param array $lines(一维)
     * @return boolean
     */
    function writeAllToFile($filepath, $lines)
    {
        //为了安全写入，在覆盖之前取出所有数据，以便失败重新存入
        $handle = fopen($filepath, "r");
        $oldLines = $this->getAllLinesFromFile($filepath);

        $result = true;
        $handle = fopen($filepath, "w");
        foreach ($lines as $line) {
            if (!$this->writeLineToFile($filepath, $line)) {
                $result = false;
                break;
            }
        }

        //如果写入失败就存入原值
        if (!$result) {
            foreach ($oldLines as $line) {
                $this->writeLineToFile($filepath, $oldLines);
            }
        }

        fclose($handle);
        return $result;
    }

    /**
     * 序列化所有的用户
     *
     * @return array
     */
    function unserializeUsers()
    {
		$util=new Util();
        $lines = $this->getAllLinesFromFile($util->getConfig('userDataFilePath'));
        $users = [];

        foreach ($lines as $line) {
            $users[] = $this->unserializeUser($line);
        }

        return $users;
    }

}
