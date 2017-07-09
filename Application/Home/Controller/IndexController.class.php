<?php
namespace Home\Controller;
use EasyWeChat\Foundation\Application;
use Home\Common\Controller\CommonController;
use Common\Service\Sms;
use Think\Log;

class IndexController extends CommonController {
	protected $member;
	protected $auth_group_access;

	//激活入口页面
	public function index(){
 		//WeChat API
		$options = C('EASY_WECHAT');
		$app = new Application( $options);
		$js = $app->js;

		$this->check_login();
		$this->assign('member',$member);
		$this->assign('js',$js);
		$this->display();
	}


	// 激活页面
	public function test_index()
	{
		$this->check_login();

		$this->display('index');
	}

	public function jihuo()
	{
		$Member     = M('Member');
	  $Machine     = M('Machine');

		$this->check_login();
  	//二维码
		$machine_id = I('machine_id');
		$machine = $Machine->where('machine_id=\''.$machine_id.'\'')->find();
		if( !$machine )
		{
			$path = $_SERVER['DOCUMENT_ROOT'].'/exe/ConsoleApplication1.exe';
			exec($path, $ret);

			$combo_info = $ret[0];
			// status, temporary_code, permanent_code
			$splited_info = explode(',', $combo_info);
			$status = intval( $splited_info[0]);
			$permanent_code =  $splited_info[1];
			$temporary_code =  $splited_info[2];
			$engineer_id =  ( $this->auth_group_access['group_id'] == 2 ?  $this->auth_group_access['group_id'] : 0);
			$customer_id =  ( $this->auth_group_access['group_id'] == 1 ?  $this->auth_group_access['group_id'] : 0);

					$data = array(
						'machine_id'     => $machine_id,//机器id
						'engineer_id'    => $engineer_id,//工程师id
						'customer_id'    => $customer_id,//客户id
						'permanent_code' => $permanent_code,//永久激活码
						'temporary_code' => $temporary_code,//临时激活码
					);
					$machine = $Machine->add($data);
		}
		Log::write( 'before status' );

		$data['status']  = 0;
		if( $machine )
		{
			$data['status']  = 1;

			if( $this->auth_group_access['group_id'] == 2 )// 工程师
			{
				$data['code']  = $machine['temporary_code'];
			}

			if( $this->auth_group_access['group_id'] == 1 )// 客户
			{
				$data['code']  = $machine['permanent_code'];
			}
		}else{
			$data['error'] = '无法识别该设备，请联系客服';
		}
 		$this->ajaxReturn($data);
	}

	public function test_jihuo()
	{
		$code = I('code');
		$path = $_SERVER['DOCUMENT_ROOT'].'/exe/ConsoleApplication1.exe';
		exec($path, $arr);
		var_dump( $arr );
		$info = $arr[0];
		$this->assign('info',$info);
		$this->display('jihuo');
	}

  // 发送手机验证码
	public function send_vcode()
	{
		$config = C('ALIDAYU');
		$mobile = I('post.mobile');
		$code = 0;
		$data['status']  = 1;
		if( !$config['disable'] ){
			$sms = new Sms();
			$code = $sms->send_code($mobile);
		}else {
			 $code = 9999;
		}
		if( $code > 0 )
		{
			$sms_data = ['vcode'=>$code, 'mobile'=>$mobile, 'created_at'=>time() ];
			Log::write( print_r($sms_data,true) );
			session('sms_data',$sms_data);
		}else {
			$data['status']  = 0;
		}

		$this->ajaxReturn($data);
		//$this->ajaxReturn('1','添加信息成功',1);
	}


	//登陆处理
	public function login(){
		if(I('machine_id')==''){
			$this->error('操作失败！');
		}

		$Member     = M('Member');
		$Machine     = M('Machine');
		$AuthGroupAccess     = M('AuthGroupAccess');

		$data = array(
			'username'  => I('username'),
			'telephone' => I('telephone'),
		);

		$user_info = $Member->where('username=\''.I('username').'\' AND telephone=\''.I('telephone').'\'')->find();

		if(!$user_info){
			$result = $Member->add($data);
			if($result) {
				$access_data = array(
					'uid'      => $result,
					'group_id' => I('group_id')
				);

				$access_result = $AuthGroupAccess->add($access_data);

				if($access_result) {
					//加密
					$base = urlencode(base64_encode(I('machine_id').'-'.I('group_id').'-'.$result));

					$this->redirect('Index/code', array('base' => $base));
				}else{
					$this->error('操作失败！');
				}


			}else{
				$this->error('操作失败！');
			}
		}else{
			//加密
			$base = urlencode(base64_encode(I('machine_id').'-'.I('group_id').'-'.$user_info['id']));

			$this->redirect('Index/display_code', array('base' => $base));
		}
	}

	//计算激活码并插入机器数据表
	public function code(){
		//解密
		$base = base64_decode(urldecode(I('base')));

		$base_arr = explode('-',$base);


		if(!$base_arr[2]){
			$this->error('操作失败！');
		}

		$Member     = M('Member');

		if(!$Member->where('id='.$base_arr[2])->find()){
			$this->error('操作失败！');
		}

		$Machine     = M('Machine');

		///机器id
		$machine_id = $base_arr[0];
		//用户组id
		$group_id   = $base_arr[1];
		//用户id
		$uid        = $base_arr[2];


		//判断是商户还是工程师
		if($group_id == 1){
			//这里计算客户激活码,参数$machine_id,$group_id;

			//这里计算客户激活码,参数$machine_id,$group_id;

			$data = array(
				'machine_id'     => $machine_id,//机器id
				'customer_id'    => $uid,//客户id
				'permanent_code' => '44545454545'//永久激活码，接口获得
			);

			if(!$Machine->where('machine_id=\''.$machine_id.'\'')->find()){
				$result = $Machine->add($data);

				if($result) {
					//加密
					$base = urlencode(base64_encode($machine_id.'-'.$group_id .'-'.$uid));

					$this->redirect('Index/display_code', array('base' => $base));
				}else{
					$this->error('操作失败！');
				}
			}else{
				$result = $Machine->where('machine_id=\''.$machine_id.'\'')->save($data);

				if($result) {
					//加密
					$base = urlencode(base64_encode($machine_id.'-'.$group_id .'-'.$uid));

					$this->redirect('Index/display_code', array('base' => $base));
				}else{
					$this->error('操作失败！');
				}
			}
		}else{
			//这里计算工程师激活码,参数$machine_id,$group_id

			//这里计算工程师激活码,参数$machine_id,$group_id

			$data = array(
				'machine_id'     => $machine_id,//机器id
				'engineer_id'    => $uid,//工程师id
				'temporary_code' => '44545454545'//临时激活码，接口获得
			);
			if(!$Machine->where('machine_id=\''.$machine_id.'\'')->find()){
				$result = $Machine->add($data);

				if($result) {
					//加密
					$base = urlencode(base64_encode($machine_id.'-'.$group_id .'-'.$uid));

					$this->redirect('Index/display_code', array('base' => $base));
				}else{
					$this->error('操作失败！');
				}
			}else{
				$result = $Machine->where('machine_id=\''.$machine_id.'\'')->save($data);

				if($result) {
					//加密
					$base = urlencode(base64_encode($machine_id.'-'.$group_id .'-'.$uid));

					$this->redirect('Index/display_code', array('base' => $base));
				}else{
					$this->error('操作失败！');
				}
			}
		}
	}
	//显示激活码
	public function display_code(){
		//解密
		$base = base64_decode(urldecode(I('base')));

		$base_arr = explode('-',$base);

		if(!$base_arr[2]){
			$this->error('操作失败！');
		}

		$Member     = M('Member');

		if(!$Member->where('id='.$base_arr[2])->find()){
			$this->error('操作失败！');
		}

		$Machine     = M('Machine');

		///机器id
		$machine_id = $base_arr[0];
		//用户组id
		$group_id   = $base_arr[1];
		//用户id
		$uid        = $base_arr[2];

		//判断是商户还是工程师
		if($group_id == 1){
			$code = $Machine->where('customer_id='.$uid.' AND machine_id=\''.$machine_id.'\'')->getField('permanent_code');
		}else{
			$code = $Machine->where('engineer_id='.$uid.' AND machine_id=\''.$machine_id.'\'')->getField('temporary_code');
		}

		$this->assign('code',$code);

		$this->display();
	}

	protected function check_login(){

		if( session('mid') == null){
			$this->error('您还没有登录！',U('/Home/Session/'));
		}
		$Member = M('Member');
		$AuthGroupAccess  = M('AuthGroupAccess');
		$this->member = $Member->where('id=%d', array(session('mid')))->find();

		Log::write( print_r($this->member,true) );

		if( $this->member == null)
		{
			session('mid', null);
			$this->error('您还没有登录！',U('/Home/Session/'));
		}

		$this->auth_group_access = $AuthGroupAccess->where('uid=%d', array( $this->member['id']))->find();

	}
}
