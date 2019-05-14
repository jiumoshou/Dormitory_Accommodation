<?php /*a:1:{s:82:"H:\Study\wamp64\www\tp5.1\application/dormitory_accommodation/view\resgin\add.html";i:1557736416;}*/ ?>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0">
		<title>新建入住人员</title>
		<link rel="stylesheet" type="text/css" href="/tp5.1/public/static/Dormitory_Accommodation/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="/tp5.1/public/static/layui/css/layui.css" />
		<link rel="stylesheet" type="text/css" href="/tp5.1/public/static/Dormitory_Accommodation/css/edit_common.css" />
		<link rel="stylesheet" type="text/css" href="/tp5.1/public/static/Dormitory_Accommodation/css/Resgin/add.css" />
		<script type="text/javascript" src="/tp5.1/public/static/Dormitory_Accommodation/js/jquery-3.3.1.js"></script>
		<script type="text/javascript" src="/tp5.1/public/static/layui/layui.js"></script>
		<script type="text/javascript" src="/tp5.1/public/static/Dormitory_Accommodation/js/resgin.js"></script>
	</head> 

	<body>
		<div class="layui-fluid ">
			<div class="layui-card ">
				<div class="layui-card-header ">注册</div>
				<div class="layui-card-body">
					<form action="<?php echo url( 'Resgin/insert'); ?> " class="layui-form " lay-filter="component-form-group" method="post ">
						<div class="layui-form-item ">
							<label class="layui-form-label ">姓名：</label>
							<div class="layui-input-block ">
								<input required name="User_name" class="layui-input " type="text " lay-verify="required " autocomplete="off " placeholder="请输入标题 ">
							</div>
						</div>
						<div class="layui-form-item">
							<label class="layui-form-label">性别：</label>
							<div class="layui-input-block">
								<input type="radio" id="User_sex" name="User_sex" lay-filter="User_sex" value="男" title="男">
								<input type="radio" id="User_sex" name="User_sex" lay-filter="User_sex" value="女" title="女">
							</div>
						</div>
						<div class="layui-form-item ">
							<label class="layui-form-label ">IDcard：</label>
							<div class="layui-input-block ">
								<input required name="User_IDcard" class="layui-input " type="text " lay-verify="required " autocomplete="off " placeholder="请输入标题 ">
							</div>
						</div>
						<div class="layui-form-item ">
							<label class="layui-form-label ">民族：</label>
							<div class="layui-input-block ">
								<select id="User_nation" lay-filter="User_nation" required name="User_nation" lay-verify="required ">
									<option value="" selected=""></option>
								</select>
							</div>
						</div>
						<div class="layui-form-item">
							<label class="layui-form-label">宿舍号：</label>
							<div class="layui-input-block" id="select_div">
								<select id="my_select_select" lay-filter="sushehao">
								</select>
								<input required name="Dormitory_name" class="layui-input" id="my_select_text" type="text " lay-verify="required " autocomplete="off " placeholder="昆仑2#110 ">
							</div>
						</div>
						<div class="layui-form-item layui-layout-admin ">
							<div class="layui-input-block ">
								<div class="layui-footer " style="left: 0; ">
									<!--<input required type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success " value="提交 ">-->
									<input type="submit" class="layui-btn" lay-submit="LAY-user-login-submit" lay-filter="component-form-demo1 " value="立即提交">
									<button type="reset" class="layui-btn layui-btn-primary ">重置</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>

</html>