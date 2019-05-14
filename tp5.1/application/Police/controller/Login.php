<?php
namespace app\Police\Controller;

use think\Controller;
use app\Admin\Model;
use think\Session;

//后台登录类
class Login extends Controller  {

    public function index()	{       	//登录页展示
    	
    	return $this->fetch();
    }

    public function login() {			//验证登录

		$username = $_POST['username'];
		$password = $_POST['password'];
		$option   = $_POST['option'];

    	$User = model('User');
		$result = $User->CheckLogin($username,$password,$option);

		if($result)
		{
			\Session::set('Adminer',$username);	//登录成功
			$this->success('登录成功','Index/index');
		}
		else {

			$this->error('账号信息有误!');
		}
	}

    public function register() {			//登录注册

    	$User = model('User');

		if($_POST['password'] == $_POST['repassword'])
		{
			if($User->where(Array("User_name"=>$_POST['username']))->find())
			{
				$this->error("名称重复");
			}

	    	$data = Array(
			 "User_name"  => $_POST['username'],
			 "User_psd"   => $_POST['password'],
			 "User_email" => $_POST['email'],
		     "User_type"  => $_POST['option']
	     	);

	     	if($_POST["id"] == "3327" && $_POST['option'] == 0)
	     	{
	    		$User->create($data);
	    	}
	    	else if ( $_POST['option'] == 0)
	    	{
	    		$this->error("管理员通行密码错误");
	    	}
	    	else
	    	{
	    		$User->create($data);
	    	}

			Session::set('Adminer',$_POST['username']);	//登录成功
			$this->success('注册成功','Index/index',2);
		}
		else {

			$this->error('密码不一致!');
		}
	}

}