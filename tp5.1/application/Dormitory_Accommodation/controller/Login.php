<?php
namespace app\Dormitory_Accommodation\controller;

use think\Controller;
use app\Dormitory_Accommodation\Model;
use think\Session;
class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function ddd()
    {
        return $this->fetch();
    }
	public function login(){
		$username=$_POST["username"];
		$userpass=$_POST["userpass"];
		$User = model('User');
		$result = $User->CheckLogin($username,$userpass);

		if($result)
		{
			\Session::set('Adminer',$username);	//登录成功
			return(
					['url'=>'/tp5.1/public/Dormitory_Accommodation/Index/index']
//					['url'=>'{:url(\'Index/index\')}']
			);
			//$this->success('Index/index');
		}
		else {
			echo '账号信息有误！';
			//$this->error('账号信息有误!');
		}
		
		

	}
}
