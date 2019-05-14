<?php
namespace app\Dormitory_Accommodation\controller;

use think\Controller;
use app\Dormitory_Accommodation\Model;
use think\Session;
use think\Cookie;
use think\Request;

//初始化类
class Check extends Common  {

    public function index($id) {
    	$Checkm= model('Common/Checkm');
		$User = model('Common/User');
		
		$join = [
				['User u','a.User_id=u.User_id'],
				['dormitory d','a.Dormitory_id=d.Dormitory_id'],
			];
		$thisuser=$Checkm->alias('a')->join($join)->where('a.Dormitory_id','=',$id)->select();
		$this->assign('User',$thisuser);
        return $this->fetch();
    }
}
?>