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
    
	</head>
	
	<body>
		<form action="<?php echo U('login');?>" method="post">
    	<div>
      用户类型
    	<select name="group_id">
      	<option value="1">客户</option>
        <option value="2">工程师</option>
      </select>
      </div>
      <div>
      姓名:<input name="username" type="text">
      </div>
      <div>
      电话:<input name="telephone" type="text">
      </div>
      <div>
      <input name="machine_id" type="hidden" value="45678"><!--这个地方是二维码返回的机器id,可以直接get-->
      <input type="submit" value="获取激活码">
      </div>
    </form>
	</body>
</html>