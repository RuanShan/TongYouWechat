<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.3 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>后台管理</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="/Public/Admin/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="/Public/Admin/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="/Public/Admin/fonts/style.css">
		<link rel="stylesheet" href="/Public/Admin/css/main.css">
		<link rel="stylesheet" href="/Public/Admin/css/main-responsive.css">
		<link rel="stylesheet" href="/Public/Admin/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="/Public/Admin/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
		<link rel="stylesheet" href="/Public/Admin/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="/Public/Admin/css/theme_light.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="/Public/Admin/css/print.css" type="text/css" media="print"/>
		<!--[if IE 7]>
		<link rel="stylesheet" href="/Public/Admin/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login example2">
		<div class="main-login col-sm-4 col-sm-offset-4">
			<div class="logo">CLIP<i class="clip-clip"></i>ONE
			</div>
			<!-- start: LOGIN BOX -->
			<div class="box-login">
				<h3>后台登录</h3>
				<p>
					请输入您的用户名和密码进行登录操作。
				</p>
				<form method="post" action="<?php echo U('Login/checklogin');?>">
					<fieldset>
						<div class="form-group">
							<span class="input-icon">
								<input type="text" class="form-control" name="username" placeholder="用户名">
                <i class="fa fa-user"></i> </span>
							</span>
						</div>
						<div class="form-group form-actions">
							<span class="input-icon">
								<input type="password" class="form-control" name="password" placeholder="密码">
                <i class="fa fa-lock"></i>
							</span>
						</div>
            <div class="form-group form-actions">
							<span class="input-icon">
								<input type="text" class="form-control" name="verify" placeholder="验证码">
                <i class="fa fa-retweet"></i>
							</span>
              <img id="verify" src="<?php echo U('verify');?>" width="100%">
              <div id="verify_btn"><i class="clip-spinner-4"></i> 看不清，点击此处换一张验证码</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-bricky pull-right">
								登录 <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
					</fieldset>
				</form>
			</div>
			<!-- end: LOGIN BOX -->
			<!-- start: COPYRIGHT -->
			<div class="copyright">
				2014 &copy; clip-one by cliptheme.
			</div>
			<!-- end: COPYRIGHT -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="/Public/Admin/plugins/respond.min.js"></script>
		<script src="/Public/Admin/plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="/Public/Admin/js/jquery.1.10.2.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="/Public/Admin/js/jquery.2.0.3.js"></script>
		<!--<![endif]-->
		<script src="/Public/Admin/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="/Public/Admin/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="/Public/Admin/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
		<script src="/Public/Admin/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="/Public/Admin/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="/Public/Admin/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="/Public/Admin/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="/Public/Admin/plugins/less/less-1.5.0.min.js"></script>
		<script src="/Public/Admin/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="/Public/Admin/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
		<script src="/Public/Admin/js/main.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
			});
			//转换验证码
			$(function(){
				$('#verify_btn').css('cursor','pointer')
				$('#verify_btn').click(function(){
					$('#verify').attr('src',"<?php echo U('verify');?>?a="+Math.random());
				})
			})
		</script>
	</body>
	<!-- end: BODY -->
</html>