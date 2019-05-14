<?php
namespace app\family\controller;

use think\Controller;
use app\family\Model;
use think\Session;
use think\Log;
class Login extends Controller
{
	public function login(){
		$user_name=$_POST["user_name"];
		$user_password=$_POST["user_password"];
		$User = model('User');
		$options = Array(
			'user_name' => $user_name,
			'user_password' => $user_password,
			//'User_type' => $option
			);

		$result = $User->where($options)->find();
		if($result)
		{
			$user_type=$User->where('user_name',$user_name)->field('user_type')->find();
			$data= json_decode($user_type,true);
			$data['msg']='1';
			$data['user_name']=$user_name;
			$data['url']='/family';
			return json($data,200);
		}
		else {
			$data1['msg']='0';
			return json($data1,200);
		}
	}
	public function loginout() {        //退出
    	$data['msg']='1';
		return json($data,200);
    }
}
