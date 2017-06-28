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
		<?php echo ($code); ?>
	</body>
</html>