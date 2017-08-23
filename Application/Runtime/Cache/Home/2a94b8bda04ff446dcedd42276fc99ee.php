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
<script>
var TongYou = {
  routes:{
    send_vcode_url:  "<?php echo U('/home/index/send_vcode');?>",
    jihuo2t_url:"<?php echo U('/Home/Index/jihuo2?activate=t');?>",
    jihuo2p_url:"<?php echo U('/Home/Index/jihuo2?activate=p');?>",
    delete_machine_url:"<?php echo U('/Home/Index/delete_machine');?>",
    login_url:"<?php echo U('/Home/Session/login');?>",
    jihuo_url:"<?php echo U('/Home/index/jihuo');?>",
    display_code_url:"<?php echo U('/Home/index/display_code');?>",
    shift_customer_service_url:"<?php echo U('/Home/index/shift_customer_service');?>",
  }
}
</script>
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
.demos-header .avatar{
  border-radius: 100%;
  margin: 8px;
  width: 60px;
  height: 60px;
  line-height: 60px;
  text-align: center;
}
.demos-title {
    text-align: center;
    font-size: 34px;
    color: #3cc51f;
    font-weight: 400;
    margin: 0 10%;
}
.weui-cells, .weui-cells_form{ margin: 0;padding: 0 0 18px 0;}
.activation-info{ padding: 18px 0; margin: 0 10%;  }
.activation-info .weui-flex__item{  padding: 0 9px;}
.two-btn-area .weui-flex__item{  padding: 0 9px;}
.weui-form-preview__item{ text-align: left;}
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
										$("#scan_device").removeClass('weui-btn_loading');
										$("#scan_device").click(function(){
											wx.scanQRCode({
											  needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
											  scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
											  success: function (res) {
													var category_id = $('#category_id').val();
											    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
													var loading = weui.loading('当前设备码为'+result);

													$.ajax({type:'POST', url: TongYou.routes.jihuo_url,
													  data:{machine_code: result, category_id: category_id},
														success: function(data){
															loading.hide();
															 if(data.status== 1)
															 {
																  location.href = TongYou.routes.display_code_url;
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
	       童游互动产品
	    </div>
		</header>
		<div class="">

				<form action="<?php echo U('login');?>" method="post">
					<div class="weui-cells weui-cells_form">
						<?php if(($member["group_id"]) == "2"): ?><div class="weui-cell weui-cell_select weui-cell_select-after">
						        <div class="weui-cell__hd">
						          <label for="" class="weui-label">设备类型</label>
						        </div>
						        <div class="weui-cell__bd">
						          <select id="category_id" class="weui-select" name="category_id">
												<?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?><option value="<?php echo ($category['id']); ?>"><?php echo ($category["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						          </select>
						        </div>
						</div><?php endif; ?>

						<div class="weui-btn-area">
							<?php if(in_array(($member["group_id"]), explode(',',"3,4"))): if(($member["cs_status"]) == "1"): ?><input id="customer_service" type="button" class="weui-btn weui-btn_primary" value="登出客服">
								<?php else: ?>
	  							<input id="customer_service" type="button" class="weui-btn weui-btn_primary" value="登录客服"><?php endif; ?>
							<?php else: ?>
		  	        <input id="scan_device" type="button" class="weui-btn weui-btn_primary weui-btn_loading" value="扫描设备"><?php endif; ?>
			      </div>
					</div>
		    </form>
		</div>
	</body>
</html>