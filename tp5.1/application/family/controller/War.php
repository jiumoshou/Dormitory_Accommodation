<?php
namespace app\family\controller;

use think\Controller;
use app\family\Model;
use think\Session;
use think\Db;
class War extends Controller
{
	public function ls()
    {
    	$data = Db::table('war')->field('war_id')->select();
		return json($data,200);
    }
    
    public function find($war_id)
    {
    	$data = Db::table('war')->where('war_id',$war_id)->select();
		return json($data,200);
    }
	public function lsmanager($page,$limit)
    {
    	$result['data']= Db::table('war')->page($page,$limit)->select();
		$result['code']='0';
		$result['count']=Db::table('war')
				->count();	
		return json($result,200);
    }
	public function edit()
	{
		$war_id=\Request::only('war_id');
		$data=\Request::except('war_id');
		$result['msg']=Db::name('war')
					->where($war_id)
					->update($data);
		return json($result,200);
	}
	public function insert()
	{
		$data = $_REQUEST;
		$result1=Db::name('war')->insert($data);
		if($result1){
			return json("家族战人员提交成功",200);
		}
	}
}
?>