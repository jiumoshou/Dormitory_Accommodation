<?php
namespace app\wx\controller;

use think\Controller;
use app\wx\Model;
use think\Session;
class Commodity extends Controller
{
    public function index()
    {
//      return $this->fetch();
    }
	//小程序主页top数据接口
	public function index_top(){
		$Commodity = model('Commodity');
		$result = $Commodity->select();	
		return json($result, 200);
		
	}
	public function top(){
		$commodity_id=$_POST["commodity_id"];
		$data['commodity_id']=$commodity_id;
		$Commodity = model('Commodity');
		$result = $Commodity->where($data)->select();	
		return json($result, 200);
		
	}
}
?>