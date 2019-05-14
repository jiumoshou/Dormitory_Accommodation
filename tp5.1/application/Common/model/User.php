<?php
namespace app\Common\Model;

use think\Model;

//用户模型类
class User extends Model {

	public function CheckLogin($user_name,$user_password) {		//检查管理用户登录

		$options = Array(
			'user_name' => $user_name,
			'user_psd' => $user_password,
			//'User_type' => $option
			);

		$result = self::where($options)->find();

		return (bool)$result;
	}
	
	public function CheckLogin_openid($openid) {		//检查管理用户登录

		$options = Array(
			'openid' => $openid,
			);

		$result = self::where($options)->find();

		return (bool)$result;
	}
	
	public function CheckLogin_username($username,$password) {		//检查管理用户登录

		$options = Array(
			'User_name' => $username,
			'User_psd' => $password,
			//'User_type' => $option
			);

		$result = self::where($options)->find();

		return (bool)$result;
	}
}