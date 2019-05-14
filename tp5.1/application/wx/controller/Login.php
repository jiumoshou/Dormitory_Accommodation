<?php
namespace app\wx\controller;

use think\Controller;
use app\wx\Model;
use think\Session;
class Login extends Controller
{
    public function index()
    {
//      return $this->fetch();
    }
    public function ddd()
    {
        return $this->fetch();
    }
	public function login(){
		$code=$_POST["code"];
		$data=$this->GetWechatOpenId($code);
		$openid=$data["openid"];//用户唯一标识
		$session_key=$data["session_key"];//会话密钥
		$User = model('User');
		$result = $User->CheckLogin_openid($openid);

		if($result)
		{
			$openid1['openid']=$openid;
			$user_id = $User->where($openid1)->field('user_id')->find();
			$user_id1=$user_id['user_id'];
			\Session::set('Adminer',$user_id1);	//登录成功
			$data1['message']='success';
			$data1['user_id']=$user_id['user_id'];
			return json($data1, 200);
		}
		else {//写入微信唯一标识符并登陆
			$data1['openid']=$openid;
			$d1=$User->create($data1);
			$user_id = $User->where($data1)->field('user_id')->find();
			$user_id1=$user_id['user_id'];
			\Session::set('Adminer',$user_id1);	//登录成功
			$data1['message']='success';
			$data1['user_id']=$user_id['user_id'];
			return json($data1, 200);
		}
	}
	
	//数据处理
	function GetWechatOpenId($js_code)
	{
	    if (!$js_code) {
	        throw new \Exception('code参数为null！');
	    }
	 
	    //获取openid和session的地址
	    //即 https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code
	    $url='https://api.weixin.qq.com/sns/jscode2session';
	    //定义好的appid、appsecret等有关小程序配置的数组常量
	    $param=array();
	    $param[]='appid=wxc5efbf68311bf7f6';
	    $param[]='secret=31f3a43f1fa6aee1479cf9059f8cbbc2';
	    $param[]='js_code='.$js_code;
	    $param[]='grant_type=authorization_code';
	 
	    $params=join('&',$param);
	 
	    $url=$url.'?'.$params;
	    $result=$this->curl_file_get_contents($url,'post');
	 
	    $result=json_decode($result,true);
	    return $result;
	}
	
	
	  /*
     *  php访问url路径，get请求
     */
    function curl_file_get_contents($url,$method='POST',$data=''){
        $curl = curl_init(); // 启动一个CURL会话
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
	    $tmpInfo = curl_exec($curl);     //返回api的json对象
	    //关闭URL请求
	    curl_close($curl);
     	return $tmpInfo;    //返回json对象

    }
}
