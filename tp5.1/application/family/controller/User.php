<?php
namespace app\family\controller;

use think\Controller;
use app\family\Model;
use think\Session;
use think\Request;
use think\Collection;
use think\Log;
use think\Db;
class User extends Controller
{
    public function index()
    {
//      return $this->fetch();
    }
    public function c(){
    	$user=\Request::param();
    	$result1=Db::name('c')->insert($user);
    }
    public function w1(){
    	$user=\Request::param();
    	$result1=Db::name('w1')->insert($user);
    }
	public function register()
	{
		$user_id=\Request::only('user_id');
		$user=\Request::only('user_id,user_name,user_password');
		$information=\Request::except('user_id,user_name,user_password');
		$result1=Db::name('user')->insert($user);
		$result2=Db::name('information')
					->where($user_id)
					->update($information);
		if($result1&&$result2){
			return json("更新成功",200);
		}
	}
    public function message()
	{
		$user_id = Db::table('user')->where('user_name',$_POST["user_name"])->field('user_id')->find();
		$information=Db::table('information')->where($user_id)->find();
		$Users = Db::table('user')->where('user_name',$_POST["user_name"])->find();
		$data=array_merge($Users,$information);
		return json($data,200);
	}
	public function save()
	{
		$user_id=\Request::only('user_id');
		$user=\Request::only('user_name,user_password');
		$information=\Request::except('user_id,user_name,user_password');
		$result1=Db::name('user')
					->where($user_id)
					->update($user);
		$result2=Db::name('information')
					->where($user_id)
					->update($information);
		if($result1&&$result2){
			return json("更新成功",200);
		}
	}
	public function user_manager($page,$limit)
	{
		$information=Db::table('information')->select();
		$result['data']=Db::table(['user','information'])
				->where('user.user_id=information.user_id')
				->order('post_id')
				->page($page,$limit)
				->select();
		$result['code']='0';
		$result['count']=Db::table('user')
				->count();	
		return json($result,200);
	}
	public function manager()
	{
		$user_id=\Request::only('user_id');
		$data=\Request::except('user_id');
		$result['msg']=Db::name('information')
					->where($user_id)
					->update($data);
		return json($result,200);
	}
	public function manager_del()
	{
		$user_id=\Request::only('user_id');
		Db::name('user')->where($user_id)->delete();
		$result['msg']=Db::name('information')
					->where($user_id)
					->delete();
		return json($result,200);
	}
}
?>