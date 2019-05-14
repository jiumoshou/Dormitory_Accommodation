<?php
namespace app\Dormitory_Accommodation\controller;

use think\Controller;
use think\Request;
use think\Session;
use think\Log;
//用户控制类
class Resgin extends Controller {
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
			if($Dormitory_id==null){
				$Dormitory_insertdata=\Request::instance()->only(['Dormitory_name']);
				$User_sex=\Request::instance()->only(['User_sex']);
				$Dormitory_insertdata['Dormitory_sex']=$User_sex['User_sex'];
				$Dormitory_insertdata['Dormitory_oc']=0;
				$Dormitory_insertdata['Dormitory_few']=0;
				$Dormitory->create($Dormitory_insertdata);
				$Dormitory_id=$Dormitory->where($Dormitory_name)->field('Dormitory_id')->find();
			}
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

				$this->success('添加成功','Login/index',3);
			}
			else {

				$this->error('添加失败!');
			}
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
}

