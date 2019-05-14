<?php
namespace app\family\controller;
use think\Controller;
use app\family\Model;
use think\Session;
use think\Cookie;
use think\Request;
use think\log;
//后台初始化类
class Index extends Controller  {

    public function index(Request $request)	{ 

    	$this->assign('username',$request->Session('Adminer'));
//  	return $this->fetch();
    }
    
    public function picture(){
    	$Picture = model('Picture');
    	$famlePath = $Picture->where('picture_type','index')->field('picture_path')->select();
    	for($i=0;$i<count($famlePath);$i++){
		    	$famlePath=$famlePath[$i]['picture_path'];
		        $file_dir = root_path . 'public' . DS . 'image' . '/' . "$famlePath";    // 下载文件存放目录
		        // 检查文件是否存在
		        if (! file_exists($file_dir) ) {
		            $this->error('文件未找到');
		        }else{
		            //以只读和二进制模式打开文件   
					$file = fopen ( $file_dir, "rb" ); 
		 
		 
					//告诉浏览器这是一个文件流格式的文件    
					Header ( "Content-type: application/octet-stream" ); 
					//请求范围的度量单位  
					Header ( "Accept-Ranges: bytes" );  
					//Content-Length是指定包含于请求或响应中数据的字节长度    
					Header ( "Accept-Length: " . filesize ( $file_dir ) );  
					//用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
					Header ( "Content-Disposition: attachment; filename=" . $famlePath );    
		 
		 
					//读取文件内容并直接输出到浏览器    
					echo fread ( $file, filesize ( $file_dir ) );    
					fclose ( $file );    
					exit ();   
				
				}
		}

    }

}