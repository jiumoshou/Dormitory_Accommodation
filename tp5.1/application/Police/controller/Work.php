<?php
namespace app\Police\controller;

use think\Controller;
use app\Admin\Model;
use think\Session;
use think\Cookie;
use think\Request;

//初始化类
class Work extends Common  {

    public function index() {

        return $this->fetch();
    }

    public function add() {

        return $this->fetch();
    }

    public function act_add() {

    	if(request()->file("file") != NULL)
    	{
    		$file = request()->file("file");

    		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/users/');

    		$path = $info->getSaveName();

	    	$token = $this->get_token();

			$url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/idcard?access_token=' . $token;
			$img = file_get_contents(ROOT_PATH . 'public' . DS . 'uploads/users/'.$path);
			$img = base64_encode($img);
			$bodys = array(
			    "image" => $img,
			    "id_card_side" => "front"
			);

			$res = json_decode($this->request_post($url, $bodys))->words_result;

			$data = Array(
				"User_IDcard" => $res->公民身份号码->words,
				"User_sex" => $res->性别->words,
				"User_email" => $res->住址->words,
				"User_type"	 => 1,
				"User_headimg" => $path,
				"User_phone" => $res->民族->words,
				"User_name"  => $res->姓名->words,
			);
			

			$userinfo = model("User")->create($data);

			$this->success("ORC识别成功，已录入该人员户籍信息!");
	    }
	    else
	    {
	    	$this->error("请上传人员身份证!");
	    }
    }

    public function act_search() {

    	if(request()->file("file") != NULL)
    	{
    		$file = request()->file("file");

    		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/users/');

    		$path = $info->getSaveName();

	    	$token = $this->get_token();

			$url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/idcard?access_token=' . $token;
			$img = file_get_contents(ROOT_PATH . 'public' . DS . 'uploads/users/'.$path);
			$img = base64_encode($img);
			$bodys = array(
			    "image" => $img,
			    "id_card_side" => "front"
			);

			$res = json_decode($this->request_post($url, $bodys))->words_result;

			$id = $res->公民身份号码->words;

			$userinfo = model("User")->where("User_IDcard",$id)->find();

			$this->assign("userinfo",$userinfo);
	        return $this->fetch();
	    }
	    else
	    {
	    	$this->error("请上传人员身份证!");
	    }
    }

    protected function get_token()
    {
		$url = 'https://aip.baidubce.com/oauth/2.0/token';
	    $post_data['grant_type']       = 'client_credentials';
	    $post_data['client_id']      = 'GFynbQlp2MElUC4qoGNljsjU';
	    $post_data['client_secret'] = 'bwhiTQdnqQlEADSbcT3gGtKbunxLISqw';
	    $o = "";

	    foreach ( $post_data as $k => $v ) 
	    {
	    	$o.= "$k=" . urlencode( $v ). "&" ;
	    }

	    $post_data = substr($o,0,-1);
	    
	    $res = $this->request_post($url,$post_data);

	    return json_decode($res)->access_token;
    }

    protected function request_post($url = '', $param = '')
	{
	    if (empty($url) || empty($param)) {
	        return false;
	    }

	    $postUrl = $url;
	    $curlPost = $param;
	    // 初始化curl
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $postUrl);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    // 要求结果为字符串且输出到屏幕上
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    // post提交方式
	    curl_setopt($curl, CURLOPT_POST, 1);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
	    // 运行curl
	    $data = curl_exec($curl);
	    curl_close($curl);

	    return $data;
	}

}
