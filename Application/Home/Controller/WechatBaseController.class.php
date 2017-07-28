<?php
namespace Home\Controller;

use Home\Lib\MysqlDoctrineCacheDriver;
use Think\Controller;
use Think\Log;

class WechatBaseController extends Controller
{
    protected $options;

    public function __construct()
    {
        $this->options = C('EASY_WECHAT');
        $cacheDriver = new MysqlDoctrineCacheDriver();
        $this->options['cache'] = $cacheDriver;
        parent::__construct();
    }


    	//
    	// 验证手机验证码
    	// return 0, 1
    	public function validate_vcode($mobile, $code)
    	{
        //for debug
        if( $code==9999)
        {
          return true;
        }
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
