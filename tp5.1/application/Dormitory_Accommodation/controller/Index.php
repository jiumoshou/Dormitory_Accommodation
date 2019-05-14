<?php
namespace app\Dormitory_Accommodation\controller;
use think\Controller;
use app\Dormitory_Accommodation\Model;
use think\Session;
use think\Cookie;
use think\Request;
//后台初始化类
class Index extends Common  {

    public function index(Request $request)	{ 

    	$this->assign('username',$request->Session('Adminer'));
    	return $this->fetch();
    }


    public function loginout() {        //退出

    	\Session::delete('Adminer');

    	$this->success('退出成功!','index.php/Dormitory_Accommodation/login/index');
    }

    public function main(Request $request)	{        //中心模块展示

        $Work = model('Work');
        $User = model("User");
        $Comment = model("Comment");

        $page = isset($_GET['page'])?$_GET['page']:1;
        
        $works = $Work->where("Work_user", $User->where("User_name",request()->Session("Adminer"))->value("User_id"))->select()->toArray();

        foreach ($works as &$value) {
        	
        	$value["score"] = $Comment->where("Comment_work",$value["Work_id"])->avg("Comment_score");
        }

        $list = action('Common/Pagelist/Getlist',['arr'=>$works,'page'=>$page,'num'=>20]);
        $pages = action('Common/Pagelist/GetCode',['arr'=>$works,'page'=>$page,'num'=>20,'url'=>'index']);

        $this->assign('Pagelist',$pages);
        $this->assign("works",$list);  
        return $this->fetch();
    }

    public function top() {

        return $this->fetch();
    }

    public function left() {

        return $this->fetch();
    }

    public function add()   {       //后台直接上传

        return $this->fetch();  
        
    }
}

