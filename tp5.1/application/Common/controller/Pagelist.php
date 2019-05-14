<?php
namespace app\Common\Controller;

use think\Controller;

//自定义分页操作类
class Pagelist extends Controller {

	public function Getlist($arr,$page=1,$num=10) {		//拿取对应页的数组

		$list = Array();
		$pagelist = ($page-1)*$num;

		for ($i = 0; $i < $num; $i++) {

			if($pagelist+$i < count($arr)) {

				$list[] = $arr[$pagelist+$i];
			}
		}

		return $list;
	}

	public function GetCode($arr,$page=1,$num=10,$url) {		//拿到对应页的分页代码

		$list = Array();
		$total = count($arr);
		$pagelist = floor($total/$num);

		for ($i = 0; $i < 5; $i++) {

			if($i <= $pagelist-$page+1) {
				$list['code'][] = Array(
					'url' => $url.'?page='.($page + $i),
					'page' => ($page + $i)
					);
			}
		}

		if($page != 1) {

			$list['pre'] = $page-1;
		}
		else {

			$list['pre'] = $page;
		}

		if($page != $pagelist+1) {

			$list['next'] = $page+1;
		}
		else {
			
			$list['next'] = $page;
		}

		return $list;

	}
}