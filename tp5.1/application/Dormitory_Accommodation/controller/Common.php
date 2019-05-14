<?php
namespace app\Dormitory_Accommodation\Controller;

use think\Controller;
use think\Session;

//公共检验用户权限类
class Common extends Controller {
	
	public function __construct() {

		parent::__construct();
		$this->CheckmAdmin();
	}

	public function CheckmAdmin() {		//判断是否是登录进入的后台操作

		if(! \Session::has('Adminer')) {		//检查是否是登录状态

			$this->error('您还未登录!','Login/index');
		}
		else
		{
			$User = model("User");
			$user = $User->where("User_name",\Session::get('Adminer'))->find();

			$this->assign("UserInfo",$user);
		}
	}
}