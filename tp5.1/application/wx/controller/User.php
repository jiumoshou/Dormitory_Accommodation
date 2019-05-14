<?php
namespace app\wx\controller;

use think\Controller;
use app\wx\Model;
use think\Session;
use think\Request;
use think\Collection;
use think\Log;
class User extends Controller
{
    public function index()
    {
//      return $this->fetch();
    }
	//小程序购物车接口
	public function cart(){
		$user_id=$_POST["user_id"];
		$data['user_id']=$user_id;
		$Cart = model('Cart');
		$Commodity = model('Commodity');
//		$result = $Cart->where($data)->select();
		$join = [
				['Commodity c','a.Commodity_id=c.Commodity_id'],
//				['dormitory d','a.Dormitory_id=d.Dormitory_id'],
			];
		$result = $Cart->alias('a')->join($join)->where($data)->select();
		return json($result, 200);
		
	}
	public function addcart(){
		$user_id=$_POST["user_id"];
		$commodity_id=$_POST["commodity_id"];
		
		$data['user_id']=$user_id;
		$data['commodity_id']=$commodity_id;
		$data['commodity_count']='1';
		$data['commodity_state']='1';
		
		$Cart = model('Cart');
		$code = $Cart->insert($data);
		if($code){
			$result['code']="success";
			$result['msg']="添加购物车成功";
		}
		else{
			$result['code']="loading";
			$result['msg']="添加购物车失败";
		}
		
		return json($result, 200);
	}
	public function updatecart(Request $request){
		$user_id=$_POST;
		$user_id=json_encode($user_id);
		$user_id=$user_id->visible(['user_id','commodity_id','commodity_count'])->toArray();
		
//		$commodity_id=$_POST["commodity_id"];
//		
//		$data['user_id']=$user_id;
//		$data['commodity_id']=$commodity_id;
//		$data['commodity_count']='1';
//		$data['commodity_state']='1';
//		
//		$Cart = model('Cart');
//		$code = $Cart->insert($data);
//		if($code){
//			$result['code']="success";
//			$result['msg']="添加购物车成功";
//		}
//		else{
//			$result['code']="loading";
//			$result['msg']="添加购物车失败";
//		}
//		$data[0]=
//			$user_id[]['user_id'];
		$Cart = model('Cart');
		$Cart=json($user_id, 200);
		return json($user_id, 200);
	}
}
?>