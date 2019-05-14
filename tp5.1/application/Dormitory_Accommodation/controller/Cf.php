<?php
namespace app\Dormitory_Accommodation\controller;
use think\Controller;
use app\Dormitory_Accommodation\Model;
use think\Session;
use think\Cookie;
use think\Request;
use think\Db;
use think\Log;
//后台初始化类
class Cf extends Common  {

    public function index(Request $request)	{ 

//  	$this->assign('username',$request->Session('Adminer'));
    	return $this->fetch();
    }

    public function main()	{        //中心模块展示
    	try{
    		\Db::query("CREATE TABLE check1(Dormitory_id int,User_id int)");
    	}catch(\Exception $e){
    	}
		$Dormitory=\Db::table('dormitory')->field("Dormitory_id,Dormitory_sex")->select();
		$Dormitory_len=count($Dormitory);
		for($k = 0;$k<$Dormitory_len;$k++){
			$Dormitory[$k]["Dormitory_oc"]='0';
			$Dormitory[$k]["Dormitory_few"]='0';
		}
		$User=\Db::table('user')->field("user_id,user_nation,user_sex")->where('user_type',1)->select();
		$User_len=count($User);
		for($i = 0;$i<$User_len;$i++){
			for($j = 0;$j<$Dormitory_len;$j++){\Log::write($User[$i]["user_id"]);
				if($Dormitory[$j]["Dormitory_oc"]>=6){
					unset($Dormitory[$j]);
					continue;
				}
				if(!($Dormitory[$j]["Dormitory_sex"]==$User[$i]["user_sex"])){
					continue;
				}
				if($User[$i]["user_nation"]=="汉族"){
					if($Dormitory[$j]["Dormitory_oc"]-$Dormitory[$j]["Dormitory_few"]>=3){
						continue;
					}else{
						$Dormitory[$j]["Dormitory_oc"]=$Dormitory[$j]["Dormitory_oc"]+1;
						$data["Dormitory_id"]=$Dormitory[$j]["Dormitory_id"];
						$data["User_id"]=$User[$i]["user_id"];
						\Db::table('check1')->insert($data);
						break;
					}
				}else{
					if($Dormitory[$j]["Dormitory_few"]>=3){
						continue;
					}else{
						$Dormitory[$j]["Dormitory_oc"]=$Dormitory[$j]["Dormitory_oc"]+1;
						$Dormitory[$j]["Dormitory_few"]=$Dormitory[$j]["Dormitory_few"]+1;
						$data["Dormitory_id"]=$Dormitory[$j]["Dormitory_id"];
						$data["User_id"]=$User[$i]["user_id"];
						\Db::table('check1')->insert($data);
						break;
					}
				}
			}
		}
		return $this->fetch('index');
	}
	public function main_cf(){
		\Db::query("DROP TABLE checkm");
		\Db::query("alter table check1 rename to checkm");
		\Db::query("UPDATE dormitory set Dormitory_oc=(SELECT COUNT(user_id) FROM `checkm` where Dormitory_id=dormitory.Dormitory_id)");
		\Db::query("UPDATE dormitory set Dormitory_few=( SELECT count(User_nation) from user WHERE User_id in(SELECT user_id from `checkm`	WHERE dormitory_id=dormitory.Dormitory_id) AND `user`.User_nation!='汉族') ");
		return $this->fetch('index');
	}
	public function select_s($page,$limit)
	{
		$User = model('Common/User');
		$join = [
				['User u','c.User_id=u.User_id'],
				['dormitory d','c.Dormitory_id=d.Dormitory_id'],
			];
		try{
			$result['data'] = Db::table("check1")->alias('c')->join($join)
												->where("u.User_type != 0")
												->order("c.Dormitory_id,u.User_id")
												->page($page,$limit)
												->select();
			$result['count']=Db::table("check1")->alias('c')->join($join)
												->where("u.User_type != 0")
												->order("c.Dormitory_id,u.User_id")
												->count();	
			}catch(\Exception $e){
				
			}								
		$result['code']='0';
		return json($result,200);
	}
	public function select_edit()
	{
		$data=\Request::param();
		\Log::write("request");
		\Log::write($data);
		$this->assign('User',$data);
		return $this->fetch('edit');
	}
}

