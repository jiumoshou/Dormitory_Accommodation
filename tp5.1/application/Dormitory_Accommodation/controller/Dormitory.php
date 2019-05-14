<?php
namespace app\Dormitory_Accommodation\controller;

use think\Controller;
use app\Dormitory_Accommodation\Model;
use think\Session;
use think\Cookie;
use think\Request;

//初始化类
class Dormitory extends Common  {

    public function index() {
		$Dormitory = model('Common/Dormitory');
		$Dormitory=$Dormitory->select();
		$this->assign('Dormitory',$Dormitory);
      return $this->fetch();
    }
    
	public function add() {		//添加宿舍

		return $this->fetch();
	}

	public function edit($id) {			//编辑宿舍数据

		$Dormitory = model('Common/Dormitory');
		$thisuser = $Dormitory->where('Dormitory_id','=',$id)->find();
		$this->assign('Dormitory',$thisuser);
		return $this->fetch();
	}
	public function update(Request $request,$id) {		//编辑更新宿舍数据

		$Dormitory = model('Common/Dormitory');
			$data = $_REQUEST;

			if($Dormitory->where("Dormitory_id",$id)->update($data)) {

				$this->success('修改成功','Dormitory/index',3);
			}
			else {

				$this->error('修改失败!');
			}
		

	}
	public function delete($id) {      //删除宿舍

        $Dormitory = model('Common/Dormitory');

        if($Dormitory->where('Dormitory_id','=',$id)->delete()) {

            $this->success('删除成功');
        }
        else {

            $this->error('删除失败');
        }
    }
	public function insert(Request $request) {		//添加宿舍数据
		$Dormitory = model('Common/Dormitory');
		$data = $_REQUEST;
		$data['Dormitory_oc']=0;
		$data['Dormitory_few']=0;
		if($Dormitory->create($data)) {
			$this->success('添加成功','Dormitory/add',3);
		}
		else {
			$this->error('添加失败!');
		}
	}
	
}
