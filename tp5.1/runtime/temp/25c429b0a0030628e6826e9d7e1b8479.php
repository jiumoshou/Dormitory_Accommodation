<?php /*a:1:{s:83:"H:\Study\wamp64\www\tp5.1\application/dormitory_accommodation/view\login\index.html";i:1557652972;}*/ ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>登录</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="/tp5.1/public/static/Dormitory_Accommodation/css/reset.css" />
		<link rel="stylesheet" href="/tp5.1/public/static/layui/css/layui.css" media="all">
		<link rel="stylesheet" href="/tp5.1/public/static/Dormitory_Accommodation/css/Login/admin.css" media="all">
		<link rel="stylesheet" href="/tp5.1/public/static/Dormitory_Accommodation/css/Login/login.css" media="all">
		<script type="text/javascript" src="/tp5.1/public/static/Dormitory_Accommodation/js/jquery-3.3.1.js"></script>
		<script type="text/javascript" src="/tp5.1/public/static/layui/layui.js"></script>
		<script type="text/javascript" src="/tp5.1/public/static/Dormitory_Accommodation/js/Login/index.js"></script>
	</head>

	<body>
		<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

			<div class="layadmin-user-login-main">
				<div class="layadmin-user-login-box layadmin-user-login-header">
					<h2>宿舍入住办理</h2>
					<p>欢迎使用，请登录</p>
				</div>
				<div class="layadmin-user-login-box layadmin-user-login-body layui-form" id="data">
					<div class="layui-form-item">
						<label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
						<input type="text" name="username" id="LAY-user-login-username" lay-verify="required" placeholder="用户名" class="layui-input">
					</div>
					<div class="layui-form-item">
						<label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
						<input type="password" name="userpass" id="LAY-user-login-password" lay-verify="required" placeholder="密码" class="layui-input">
					</div>

					<div class="layui-form-item">
						<button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-login-submit">登 录</button>
						<a href="<?php echo url( 'Resgin/add'); ?>"><button class="layui-btn layui-btn-primary resgin">注册</button></a>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>