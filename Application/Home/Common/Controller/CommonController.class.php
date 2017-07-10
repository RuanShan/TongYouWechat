<?php
namespace Home\Common\Controller;
use Think\Controller;
class CommonController extends Controller {
	//侧边栏列表
	public function _initialize(){
		//配置
		$Config     = M('Config');
		$config_data = $Config->where('id=1')->find();
		$this->assign('config_data',$config_data);
	}

	public function isMobile()
	{
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
		{
			return true;
		}
		// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA']))
		{
			// 找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
		}
		// 脑残法，判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT']))
		{
			$clientkeywords = array ('nokia',
				'sony',
				'ericsson',
				'mot',
				'samsung',
				'htc',
				'sgh',
				'lg',
				'sharp',
				'sie-',
				'philips',
				'panasonic',
				'alcatel',
				'lenovo',
				'iphone',
				'ipod',
				'blackberry',
				'meizu',
				'android',
				'netfront',
				'symbian',
				'ucweb',
				'windowsce',
				'palm',
				'operamini',
				'operamobi',
				'openwave',
				'nexusone',
				'cldc',
				'midp',
				'wap',
				'mobile'
				);
			// 从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
			{
				return true;
			}
		}
		// 协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT']))
		{
			// 如果只支持wml并且不支持html那一定是移动设备
			// 如果支持wml和html但是wml在html之前则是移动设备
			if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
			{
				return true;
			}
		}
		return false;
	}
	//验证码
	public function verify(){
		ob_clean();		//清除缓存
		$Verify = new \Think\Verify();
		$Verify->seKey = 'xhcms';
		$Verify->fontSize = 30;	//验证码字体大小
		$Verify->length = 4;	//验证码位数
		$Verify->entry();
	}

	//
	// 验证手机验证码
	// return 0, 1
	public function validate_vcode($mobile, $code)
	{
		$config = C('ALIDAYU');
		$validated = false;
		//$sms_data = ['vcode'=>$code, 'mobile'=>$mobile, 'created_at'=>time() ];
		$sms_data = session('sms_data');
		Log::write( print_r($sms_data, true ));

			if( is_array($sms_data))
			{
				// 15*60  15 分钟有效
				$seconds = time()-15*60;
				if($sms_data['vcode']== $code && $sms_data['mobile']==$mobile && $sms_data['created_at']> $seconds )
				{
					$validated = true;
				}
			}

		//$this->ajaxReturn('1','添加信息成功',1);
		return $validated;
	}

}
?>
