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
    margin: 0 15%;
}
</style>

		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
		    wx.config( <?php echo ($js->config(array('scanQRCode'), false)); ?> );
				wx.ready(function(){

					wx.checkJsApi({
					    jsApiList: ['scanQRCode'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
					    success: function(res) {
					        // 以键值对的形式返回，可用的api值true，不可用为false
					        // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
									if( res.checkResult.scanQRCode)
									{
										$("#scan_device").click(function(){
											wx.scanQRCode({
											  needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
											  scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
											  success: function (res) {
											    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
													var loading = weui.loading('当前设备码为'+result);

													$.ajax({type:'POST', url:'/Home/Index/jihuo',
													  data:{machine_id: result},
														success: function(data){
															loading.hide();
															 if(data.status== 1)
															 {
																 weui.alert("设备激活码是："+data.code);
															 }else{
																 weui.alert(data.error);
															 }
														}
												  })
												}
											});
										})
									}
					    }
					});
				})
		</script>
	</head>

	<body ontouchstart>
		<header class="demos-header">
			<div class="demos-title">
	       设备激活
	    </div>
		</header>
		<div class="">

				<form action="<?php echo U('login');?>" method="post">
					<div class="weui-cells weui-cells_form">

						<div class="weui-cell weui-cell_select weui-cell_select-after">
						        <div class="weui-cell__hd">
						          <label for="" class="weui-label">设备类型</label>
						        </div>
						        <div class="weui-cell__bd">
						          <select class="weui-select" name="select2">
						            <option value="1">设备类型1</option>
						            <option value="2">设备类型2</option>
						            <option value="3">设备类型3</option>
						          </select>
						        </div>
						</div>

						<div class="weui-btn-area">
			        <input id="scan_device" type="button" class="weui-btn weui-btn_primary" value="扫描设备">
			      </div>
					</div>
		    </form>
		</div>
	</body>
</html>