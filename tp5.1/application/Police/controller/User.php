<?php
namespace app\Police\controller;

use think\Controller;
use think\Request;
use think\Session;

//用户控制类
class User extends Common {

	public function index() {		//用户展示列表

		$page = isset($_GET['page'])?$_GET['page']:1;
		$User = model('Common/User');


		$Users = $User->where("User_type != 0")->select()->toArray();


		$list = action('Common/Pagelist/Getlist',['arr'=>$Users,'page'=>$page,'num'=>15]);					//分页代码
		$pages = action('Common/Pagelist/GetCode',['arr'=>$Users,'page'=>$page,'num'=>15,'url'=>'index']);

		$this->assign('Users',$list);
		$this->assign('Pagelist',$pages);
		return $this->fetch();
	}


	public function apply() {		//用户申请列表

		$page = isset($_GET['page'])?$_GET['page']:1;
		$Apply = model('Common/Apply');


		$applys = $Apply->select()->toArray();

		foreach ($applys as $key => &$value) {
			
			$value["Apply_user"] = model("User")->where("User_id",$value["Apply_user"])->value("User_name");
		}


		$list = action('Common/Pagelist/Getlist',['arr'=>$applys,'page'=>$page,'num'=>15]);					//分页代码
		$pages = action('Common/Pagelist/GetCode',['arr'=>$applys,'page'=>$page,'num'=>15,'url'=>'index']);

		$this->assign('applys',$list);
		$this->assign('Pagelist',$pages);
		return $this->fetch();
	}


	public function mndex() {		//用户展示列表

		$User = model('Common/User');

		$this->assign('userinfo',$User->where("User_name",Session::get("Adminer"))->find());
		return $this->fetch();

	}

	public function rupdate($id) {

		$User = model('Common/User');

		$data = $_REQUEST;
		$data["User_type"] = 0;

		if($data["User_rpsd"] != $data["User_psd"])
		{
			$this->error("密码不一致");
		}

		unset($data["User_rpsd"]);

		if($User->where("User_id",$id)->update($data)) {

			$this->success('修改成功','User/rndex',3);
		}
		else {

			$this->error('修改失败!');
		}
	}


	public function rinsert() {

		$User = model('Common/User');

		$data = $_REQUEST;
		$data["User_type"] = 0;

		if($data["User_rpsd"] != $data["User_psd"])
		{
			$this->error("密码不一致");
		}

		unset($data["User_rpsd"]);

		if($User->create($data)) {

			$this->success('添加成功','User/rndex',3);
		}
		else {

			$this->error('添加失败!');
		}
	}

	public function rndex() {		//管理员展示列表

		$page = isset($_GET['page'])?$_GET['page']:1;
		$User = model('Common/User');


		$Users = $User->where("User_type = 0")->select()->toArray();


		$list = action('Common/Pagelist/Getlist',['arr'=>$Users,'page'=>$page,'num'=>15]);					//分页代码
		$pages = action('Common/Pagelist/GetCode',['arr'=>$Users,'page'=>$page,'num'=>15,'url'=>'index']);

		$this->assign('Users',$list);
		$this->assign('Pagelist',$pages);
		return $this->fetch();
	}

	public function edit($id) {			//编辑用户数据

		$User = model('Common/User');
		$thisuser = $User->where('User_id','=',$id)->find();
		
		$this->assign('User',$thisuser);
		return $this->fetch();
	}

	public function pass($id,$type) {

		$Apply = model("Apply");
		$User = model("User");

		if($type)
		{
			$Apply->where("Apply_id",$id)->update(Array("Apply_station" => 1));
			$applyinfo = $Apply->where("Apply_id",$id)->find();
			
			$data = Array(
				"User_name" => $applyinfo->Apply_name,
				"User_sex" => $applyinfo->Apply_sex,
				"User_email" => $applyinfo->Apply_email,
				"User_phone" => $applyinfo->Apply_phone,
				"User_headimg" => $applyinfo->Apply_headimg,
				"User_IDcard" => $applyinfo->Apply_IDcard
			);

			$User->where("User_id",$applyinfo->Apply_user)->update($data);
		}
		else
		{
			$Apply->where("Apply_id",$id)->update(Array("Apply_station" => -1));
		}

		$this->success("审批处理成功!");

	}


	public function adit($id) {			//审批

		$apply = model('Common/apply');
		$thisapply = $apply->where('Apply_id','=',$id)->find();
		
		$this->assign('applyinfo',$thisapply);
		return $this->fetch();
	}



	public function mdit() {			//编辑用户数据

		$User = model('Common/User');
		$thisuser = $User->where('User_name','=',Session::get("Adminer"))->find();
		
		$this->assign('User',$thisuser);
		return $this->fetch();
	}

	public function alert() {			//编辑用户数据

		$User = model('Common/User');
		$thisuser = $User->where('User_name','=',\Session::get("Adminer"))->find();
		
		$this->assign('User',$thisuser);
		return $this->fetch();
	}

	public function add() {		//添加用户

		return $this->fetch();
	}

	public function radd() {		//添加用户

		return $this->fetch();
	}

	public function insert(Request $request) {		//插入用户数据

		$User = model('Common/User');

		$file = $request->file('User_headimg');

		if($file != NULL) {

			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/users/');
			$result = $this->validate(['file' => $file], ['file'=>'require|image'],['file.require' => '请选择上传文件', 'file.image' => '非法图像文件']);
			$path = $info->getSaveName();
		}
		else {

			$path = $request->param("User_rheadimg");
		}

		$data = $_REQUEST;
		$data["User_type"] = 1;
		$data["User_headimg"] = $path;

		if($User->create($data)) {

			$this->success('添加成功','User/add',3);
		}
		else {

			$this->error('添加失败!');
		}
	}

	public function update(Request $request,$id,$type = false) {		//编辑更新用户数据

		$User = model('Common/User');

		$file = $request->file('User_headimg');

		if($file != NULL) {

			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/users/');
			$result = $this->validate(['file' => $file], ['file'=>'require|image'],['file.require' => '请选择上传文件', 'file.image' => '非法图像文件']);
			$path = $info->getSaveName();
		}
		else {

			$path = $request->param("User_rheadimg");
		}


		if($type)
		{
			$data = $_REQUEST;

			$data["Apply_user"] = $id;
			$data["Apply_headimg"] = $path;
			unset($data["User_rheadimg"]);


			if(model("Apply")->create($data)) {

				$this->success('申请成功');
			}
			else {

				$this->error('申请失败!');
			}
		}
		else
		{
			$data = $_REQUEST;
			$data["User_type"] = 1;
			$data["User_headimg"] = $path;
			unset($data["User_rheadimg"]);

			if($User->where("User_id",$id)->update($data)) {

				$this->success('修改成功','User/index',3);
			}
			else {

				$this->error('修改失败!');
			}
		}

	}


    public function delete($id) {      //删除用户

        $User = model('Common/User');

        if($User->where('User_id','=',$id)->delete()) {

            $this->success('删除成功');
        }
        else {

            $this->error('删除失败');
        }
    }
}

