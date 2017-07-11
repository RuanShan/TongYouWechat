<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title><?php echo ($config_data["name"]); ?></title>
		<!-- metas -->
<meta charset="utf-8">
<meta name="keywords" content="<?php echo ($config_data["keywords"]); ?>" />
<meta name="description" content="<?php echo ($config_data["description"]); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
<!--/ metas -->
<link href="/Public/Home/css/weui.min.css" rel="stylesheet" type="text/css" />
<script src="/Public/Home/js/weui.js"></script>
<script src="/Public/Home/js/zepto.min.js"></script>
<script src="/Public/Home/js/app.js"></script>

<style>
body {
    font: 400 16px/1.5 "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: #111;
    background-color: #fdfdfd;
    -webkit-text-size-adjust: 100%;
}
.demos-header {
    padding: 35px 0;
}
.demos-title {
    text-align: center;
    font-size: 34px;
    color: #3cc51f;
    font-weight: 400;
    margin: 0 10%;
}
.weui-cells_form{ margin: 0;padding: 0 0 18px 0;}
.activation-info{ padding: 18px 0; margin: 0 10%;  }
.activation-info a.weui-btn{  margin: 18px;}
</style>

		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
				wx.config( <?php echo ($js->config(array('scanQRCode'), false)); ?> );
				wx.ready(function(){});
		</script>

	</head>

	<body ontouchstart>
		<header class="demos-header">
			<div class="demos-title">
	       童游互动产品
	    </div>
		</header>
		<div class="weui-form-preview">
						<div class="activation-info ">
							<?php if(($member["group_id"]) == "2"): if(empty($actived_by)): ?><p style="text-align:center;">
										激活：<?php echo ($category["title"]); ?><br>
										临时激活码：<?php echo ($machine["temporary_code"]); ?><br>
										永久激活码：<?php echo ($machine["permanent_code"]); ?>
									</p>
									<div class="weui-flex">
										<div class="weui-flex__item">
											<a id="tactivate_btn" href="javascript:;" class="weui-btn  weui-btn_primary" >  临时激活</a>
										</div>
										<div class="weui-flex__item">
											<a id="pactivate_btn" href="javascript:;" class="weui-btn  weui-btn_primary" > 永久激活</a>
										</div>
									</div>
									<?php else: ?>

									<p style="text-align:center;">
										产品已经登录<br>
										登录产品类型为：<?php echo ($category["title"]); ?><br>
										是否被用户激活：<?php echo ($actived_by["username"]); ?>
									</p>
									<br>
									<p style="text-align:center;">
										是否删除产品？
									</p>
									<div class="weui-flex">
										<div class="weui-flex__item">
											<a id="delete_btn" href="javascript:;" class="weui-btn  weui-btn_primary" >  删除</a>
										</div>
										<div class="weui-flex__item">
											<a id="close_btn" href="javascript:;" class="weui-btn  weui-btn_primary" > 返回</a>
										</div>
									</div><?php endif; ?>

							<?php else: ?>
							<p> 欢迎使用<?php echo ($category["title"]); ?>，请在游戏产品中输入以下激活码：
								<?php echo ($machine["permanent_code"]); ?>
							</p>
							<div class="weui-btn-area">
								<a  href="javascript:;" class="weui-btn weui-btn_primary" onclick="wx.closeWindow();"> 确定 </a>
							</div><?php endif; ?>
						</div>


		</div>
	</body>
</html>