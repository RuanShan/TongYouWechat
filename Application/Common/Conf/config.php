<?php
return array(
	//'配置项'=>'配置值'
	//数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型

	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'tongyou_wechat_dev', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PARAMS' =>  array(), // 数据库连接参数
	'DB_PREFIX' => 'wx_', // 数据库表前缀
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志

	//URL模式
	'URL_MODEL' => 2,
	// easywechat 配置
	'EASY_WECHAT' => [
        'debug' => true,
		'app_id' =>'wxc4a9b776dfa6840d',
        'secret' => '64eecb1b6a738377ed8c3918a0d20c1e',
        'token' => 'mytoken',
        'aes_key' => null,//'AsCXplmn6p2B2O7Vp6cEr61AzppHrJXPX9gTbGDtQRX',
        'log' => [
			'level' => 'debug',
			//'file' => '/data/home/bxu2340690158/htdocs/wechat/Application/Runtime/Logs/easywechat.log',
			'file' => 'D:\workspace\TongYouWechat\Application\Runtime\Logs\easywechat.log',
        ],
        'oauth' => [
            'scopes' => ['snsapi_userinfo'],
						'callback' => '/home/member/oauth_callback',
        ],
    ],

		'ALIYUN_SMS'=>[
			'access_key'    => 'xx',
			'access_secret' => 'xx',
			'sign_name'     => 'xx', // 签名
			'region_id'  =>'cn-beijing',
			'disable'=> false
		],
		'SESSION_OPTIONS'  =>  array('name'=>'PHPSESSID_TYWX','expire'=>3600*24*365), // session 配置数组
		'COOKIE_EXPIRE'    =>  3600*24*365,       // Cookie有效期
		'COOKIE_PREFIX'    => 'ty_',

);
