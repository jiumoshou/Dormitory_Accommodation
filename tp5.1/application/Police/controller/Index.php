<?php
namespace app\Police\controller;

use think\Controller;
use app\Admin\Model;
use think\Session;
use think\Cookie;
use think\Request;

//后台初始化类
class Index extends Common  {

    public function index(Request $request)	{       //初始化这段代码写的真垃圾(RI)(形成一个三维的数组)

    	$this->assign('username',$request->Session('Adminer'));
    	return $this->fetch();
    }


    public function loginout() {        //退出

    	\Session::delete('Adminer');

    	$this->success('退出成功!','index.php/police/login/index');
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


    public function insert() {

		$Work = model('Work');
		$User = model("User");

		$file = request()->file('Work_file');

		if($file != NULL) {

			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/works/',Date("Ymd")."/".iconv("UTF-8","GB2312//IGNORE",request()->param("Work_title")));
			$path = $info->getSaveName();
		}
		else {

			$path = "";
		}

		$data = array(

			"Work_title" => request()->param("Work_title"),
			"Work_file"  => iconv("GB2312//IGNORE","UTF-8",$path),
			"Work_user"  => $User->where("User_name",request()->Session("Adminer"))->value("User_id")
		);

		if(!$Work->where("Work_title",request()->param("Work_title"))->where("Work_user",$User->where("User_name",request()->Session("Adminer"))->value("User_id"))->find())
		{	
			$Work->create($data);
        	$this->success('上传成功','Index/add',2);
        }
        else
        {
        	$this->error('您的这期作业已经提交过了哦','Index/add',2);
        }
    }

}
