<?php
namespace app\Dormitory_Accommodation\controller;

use think\Controller;
use think\Request;
use think\Session;
use think\Log;
//用户控制类
class User extends Common {

	public function index() {		//用户展示列表
		$User = model('Common/User');
		$Checkm= model('Common/Checkm');
		$join = [
				['User u','c.User_id=u.User_id'],
				['dormitory d','c.Dormitory_id=d.Dormitory_id'],
			];
		$Users = $Checkm->alias('c')->join($join)->where("u.User_type != 0")->order("c.Dormitory_id,u.User_id")->select();
		$this->assign('User',$Users);
		return $this->fetch();
	}
	public function liebiaojson(){
		$usernation=$_POST["usernation"];
		$User_sex=$_POST["User_sex"];
		$User = model('Common/User');
		$Checkm= model('Common/Checkm');
		$Dormitory = model('Common/Dormitory');
		
		$join = [
				['User u','a.User_id=u.User_id'],
				['dormitory d','a.Dormitory_id=d.Dormitory_id'],
			];
		if($usernation=="汉族"){
			$Dormitory_id=$Dormitory->where("Dormitory_sex",$User_sex)->field('Dormitory_name')->order(['Dormitory_oc','Dormitory_few'=>'desc'])->select();
			
		}else{
			$Dormitory_id=$Dormitory->where("Dormitory_sex",$User_sex)->field('Dormitory_name')->order(['Dormitory_oc','Dormitory_few'=>'asc'])->select();
		}
		$Users = $Checkm->alias('a')->join($join)->where("u.User_type != 0")->select();
		$data=$Dormitory_id;
	//	$b=implode("",$data);  数组转字符串
		return json($data);
	}

	public function mndex() {		//用户展示列表

		$User = model('Common/User');

		$this->assign('userinfo',$User->where("User_name",Session::get("Adminer"))->find());
		return $this->fetch();

	}

	public function rupdate($id) {//修改管理员密码

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

	public function radd() {		//添加管理员

		return $this->fetch();
	}
	public function rinsert() {//添加管理员

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

		$User = model('Common/User');
		$Users = $User->where("User_type = 0")->select();
		$this->assign('Users',$Users);
		return $this->fetch();
	}

	public function edit($User_id,$Dormitory_id) {			//编辑用户数据

		$User = model('Common/User');
		$Checkm= model('Common/Checkm');
		$join = [
				['User u','a.User_id=u.User_id'],
				['dormitory d','a.Dormitory_id=d.Dormitory_id'],
			];
			
		$thisuser = $Checkm->alias('a')->join($join)->where('u.User_id','=',$User_id)->find();
		$thisuser->Dormitory_old_id=$Dormitory_id;
		$this->assign('User',$thisuser);
		return $this->fetch();
	}

	public function add() {		//添加用户

		return $this->fetch();
	}

	public function insert(Request $request) {		//插入用户数据

		$Checkm= model('Common/Checkm');
		$User = model('Common/User');
		$Dormitory = model('Common/Dormitory');
		
		$join = [
				['User u','a.User_id=u.User_id'],
				['dormitory d','a.Dormitory_id=d.Dormitory_id'],
			];
			$User_name=\Request::instance()->only(['User_name']);
			$data1=\Request::instance()->except(['Dormitory_name']);
			$usernation=\Request::instance()->only(['User_nation']);
			$Dormitory_name=\Request::instance()->only(['Dormitory_name']);
			
			$data1["User_type"] = 1;
			$d1=$User->create($data1);
			
			$Dormitory_id=$Dormitory->where($Dormitory_name)->field('Dormitory_id')->find();
			$Dormitory_id=json_decode($Dormitory_id, true);
			$User=$User->where($User_name)->field('User_id')->find();
			$User=json_decode($User, true);
			$data2=array_merge($Dormitory_id, $User);
			$d2=$Checkm->create($data2);
			
			$d3=$Dormitory->where($Dormitory_id)->setInc('Dormitory_oc');
			
			if($usernation["User_nation"]=="汉族"){
				$d4=true;
			}else{
				$d4=$Dormitory->where($Dormitory_id)->setInc('Dormitory_few');
			}
			
			if($d1&&$d2&&$d3&&$d4) {

				$this->success('添加成功','User/add',3);
			}
			else {

				$this->error('添加失败!');
			}
	}

	public function update(Request $request,$id,$type = false) {		//编辑更新用户数据

		$Dormitory = model('Common/Dormitory');
		$Checkm= model('Common/Checkm');
		$User = model('Common/User');

		
		$join = [
				['User u','a.User_id=u.User_id'],
				['dormitory d','a.Dormitory_id=d.Dormitory_id'],
			];
	//	$thisuser=$Checkm->alias('a')->join($join)->where('a.Dormitory_id','=',$id)->select();


			$data1=\Request::instance()->only(['User_id']);//更新Checkm表所需
			$data2=\Request::instance()->except(['Dormitory_name','id','Dormitory_id']);//更新user表所需
			
			$Dormitory_old_id=\Request::instance()->only(['Dormitory_id']);//更新dormitory表原宿舍人数所需
			$d3=$Dormitory->where($Dormitory_old_id)->setDec('Dormitory_oc');//更新dormitory表原宿舍人数
			$usernation=\Request::instance()->only(['User_nation']);
			$Dormitory_name=\Request::instance()->only(['Dormitory_name']);//获取新宿舍名称
			
			$Dormitory_id=$Dormitory->where($Dormitory_name)->field('Dormitory_id')->find();//获取新宿舍id

			
			$Dormitory_id=json_decode($Dormitory_id, true);//数组转化json数据，用于拼合数据更新Checkm表
			$d4=$Dormitory->where($Dormitory_id)->setInc('Dormitory_oc');//更新dormitory表新宿舍人数
			
			$data1=array_merge($Dormitory_id, $data1);//拼合数据
			
			if($usernation["User_nation"]=="汉族"){
				$d5=true;
				$d6=true;
			}else{
				$d5=$Dormitory->where($Dormitory_old_id)->setDec('Dormitory_few');
				$d6=$Dormitory->where($Dormitory_id)->setInc('Dormitory_few');
			}
			
			$d1=$Checkm->where("User_id",$id)->update($data1);//更新Checkm表
			$d2=$User->where("User_id",$id)->update($data2);//更新user表
			
			if($d1||$d2||$d3||$d4) {

				$this->success('修改成功','User/index',3);
			}
			else {

				$this->error('修改失败!');
			}
		

	}


    public function delete($id) {      //删除用户

        $Checkm= model('Common/Checkm');
		$User = model('Common/User');
		$Dormitory = model('Common/Dormitory');
		
		$join = [
				['User u','a.User_id=u.User_id'],
				['dormitory d','a.Dormitory_id=d.Dormitory_id'],
			];
		$thisuser=$Checkm->alias('a')->join($join)->where('a.Dormitory_id','=',$id)->select();
			$Dormitory_id=$Checkm->field('Dormitory_id')->where("User_id",$id)->find();
			$Dormitory_id=json_decode($Dormitory_id, true);
			$usernation=$User->where("User_id",$id)->find();
			$d1=$Checkm->where("User_id",$id)->delete();
			$d2=$User->where("User_id",$id)->delete();
			//$d3=$Dormitory->where($Dormitory_id)->setInc('Dormitory_oc');
			$d3=$Dormitory->where($Dormitory_id)->setDec('Dormitory_oc');
			
			if($usernation["User_nation"]=="汉族"){
				$d4=true;
			}else{
				$d4=$Dormitory->where($Dormitory_id)->setDec('Dormitory_few');
			}

        if($d1&&$d2&&$d3) {

            return('删除成功');
        }
        else {

            echo '删除失败';
        }
   }

}

