<?php
namespace Home\Controller;
use EasyWeChat\Foundation\Application;
use Home\Common\Controller\CommonController;
use Think\Log;
use Mrgoon\Dysmsapi\Request\V20170525\AliSms;

class IndexController extends CommonController {
	protected $member;
	protected $auth_group_access;
	protected $exe_path=null;

	public function _initialize(){
		$this->exe_path = (''.$_SERVER['DOCUMENT_ROOT'].__APP__.'/exe/ActiveKey.exe');
  }
	//激活入口页面
	public function index(){
 		//WeChat API
		$Category     = M('Category');

		$options = C('EASY_WECHAT');
		$app = new Application( $options);
		$js = $app->js;
		$this->assign('js',$js);

		$categories = $Category->select();
		$this->check_login();

		$this->assign('categories',$categories);
		$this->assign('member',$this->member);
		$this->display();
	}


	// 激活页面
	public function test_index()
	{
		//$this->check_login();

		$this->display('index');
	}

	//扫描设备码
	public function jihuo()
	{

		$Member     = M('Member');
		$Machine     = M('Machine');
		$Order     = M('Order');
		$Category     = M('Category');

		$this->check_login();

  	//二维码
		$machine_code = I('machine_code', '1234567890');
		$category_id = I('category_id' );
		$machine = $Machine->where('machine_code=\'%s\'', array($machine_code))->find();
		$machine_id = 0;
		if(!isset($machine) )
		{
			//只有工程师才能扫设备，添加machine
			if( $this->member['group_id'] == 2)
			{
				$cmd = $this->exe_path.' TongYou '.$machine_code;
				exec($cmd, $ret);

				$combo_info = $ret[0];
				// status, temporary_code, permanent_code
				$splited_info = explode(',', $combo_info);
				$status = intval( $splited_info[0]);
				Log::write( $cmd.$combo_info );
				//机器码是否有效
				if( $status == 1)
				{
					$permanent_code =  $splited_info[1];
					$temporary_code =  $splited_info[2];
					$engineer_id =    $this->member['id'];

					$machine = array(
						'category_id'     => $category_id,//产品类型
						'machine_code'     => $machine_code,//机器id
						'engineer_id'    => $engineer_id,//工程师id
						'customer_id'    => 0,//客户id
						'permanent_code' => $permanent_code,//永久激活码
						'temporary_code' => $temporary_code,//临时激活码
						'created_at' => time()
					);
					$machine_id = $Machine->add($machine);
				}
			}
		}else {
			$machine_id = $machine['id'];
			$category_id = $machine['category_id'];
		}
		Log::write( print_r( $machine,true) );

		$data['status']  = 0;
		if( $machine )
		{
			$data['status']  = 1;
			// 如果是用户，则永久激活
			if( $this->member['group_id'] == 1 )
			{
				$machine['pactivated_at'] = date('Y-m-d H:i:s');
				$machine['pactivated_by'] = $this->member['id'] ;
				$Machine->save($machine);
			}
			//工程师和客户都创建订单，以便后面确认工程师扫码了几次。
			//$data['code']  = $machine['temporary_code'];
			//$data['code']  = $machine['permanent_code'];
			//创建订单
			$order  = array(
				'category_id' => $machine['category_id'],//产品类型
				'member_id' => $this->member['id'],
				'machine_id' =>$machine_id,
				'created_at' => time()
			);
			$order_id = $Order->add($order);
			session('oid',$order_id);

		}else{
			$data['error'] = '无法识别该设备，请联系客服';
		}

 		$this->ajaxReturn($data);
	}

	//工程师选择临时激活还是永久激活
	public function jihuo2()
  {
		$this->check_login();

		$Order     = M('Order');
		$Machine     = M('Machine');
		$order_id = session('oid');
		if( empty($order_id)){
			$this->error('操作失败！');
		}

		$order = $Order->where('id='.$order_id)->find();
		if(!$order){
			$this->error('操作失败！');
		}

 		$machine_id = $order['machine_id'];
		$machine = $Machine->where('id='.$machine_id)->find();

		Log::write( print_r( $_GET,true) );

		$activate = $_GET['activate']; // 取值 t：临时,p：永久
 		if( $activate == 'p')
		{

			$machine['pactivated_at'] = date('Y-m-d H:i:s');
			$machine['pactivated_by'] = $this->member['id'] ;
			$Machine->save($machine);
		}else {
			$machine['tactivated_at'] = date('Y-m-d H:i:s');
			$machine['tactivated_by'] = $this->member['id'] ;
			$Machine->save($machine);
		}
		$this->ajaxReturn(  array('status' => 1 ));

	}

	//显示激活码
	public function display_code(){
		// 调用 wx.closeWindow();
		$options = C('EASY_WECHAT');
		$app = new Application( $options);
		$js = $app->js;

		//客户和工程师激活都有订单。
		$Member = M('Member');
		$Order     = M('Order');
		$Category     = M('Category');
		$this->check_login();

		$order_id = session('oid');
		if( empty($order_id)){
			$this->error('操作失败！');
		}

 		$order = $Order->where('id='.$order_id)->find();
		if(!$order){
			$this->error('操作失败！');
		}

		$Machine     = M('Machine');
		///机器id
		$machine_id = $order['machine_id'];
		$machine = $Machine->where('id='.$machine_id)->find();
		$category = $Category->where('id='.$machine['category_id'])->find();
		Log::write( print_r( $machine, true) );

		$pactived_by = $Member->where('id=%d', array($machine['pactivated_by']))->find();
		$tactived_by = $Member->where('id=%d', array($machine['tactivated_by']))->find();
		//判断是商户还是工程师在View中
		$this->assign('member', $this->member);
		$this->assign('machine', $machine);
		$this->assign('category', $category);
		if( $tactived_by )
		{
		  $this->assign('actived_by', $tactived_by);
			$this->assign('actived_type', '临时激活');
	  }
		if( $pactived_by )
		{
			$this->assign('actived_by', $pactived_by);
			$this->assign('actived_type', '永久激活');
		}
 		$this->assign('js',$js);

		$this->display();
	}



	// 工程师删除设备
	public function delete_machine()
	{
		$this->check_login();
		$Member = M('Member');
		$Order     = M('Order');
		$Category     = M('Category');
		$Machine     = M('Machine');

		$order_id = session('oid');
		if( empty($order_id)){
			$this->error('操作失败！');
		}

		$order = $Order->where('id='.$order_id)->find();
		if(!$order){
			$this->error('操作失败！');
		}

		$Order->where('machine_id='.$order['machine_id'])->delete();
		$Machine->where('id='.$order['machine_id'])->delete();

		session('oid', null);

		$this->ajaxReturn(  array('status' => 1 ));

	}

	//我的订单列表
	public function orders()
	{
		$this->check_login();
		$Member = M('Member');
		$Order     = M('Order');
		$Category     = M('Category');
		$Machine     = M('Machine');

		$options = C('EASY_WECHAT');
		$app = new Application( $options);
		$js = $app->js;
		$this->assign('js',$js);

		$count      = $Order->count();
    $Page       = new \Think\Page($count,12);

		$categories = $Category->select();
		$orders = $Order->order("id desc")->where('member_id='.$this->member['id'])->limit($Page->firstRow.','.$Page->listRows)->select();

		$this->assign('categories',$categories);
		$this->assign('orders',$orders);
		$this->assign('member',$this->member);
		$this->display();

	}

	//我的订单列表
	public function order_detail($order_id)
	{
		$this->check_login();
		$Member = M('Member');
		$Order = M('Order');
		$Category     = M('Category');

		if( empty($order_id)){
			$this->error('操作失败！');
		}

		$options = C('EASY_WECHAT');
		$app = new Application( $options);
		$js = $app->js;
		$this->assign('js',$js);

		$order = $Order->where('id=%d AND member_id=%d', array( $order_id, $this->member['id'] ))->find();
		if(!$order){
			$this->error('操作失败！');
		}

		$category = $Category->where('id='.$order['category_id'])->find();

		$this->assign('category',$category);
		$this->assign('order',$order);
		$this->assign('member',$this->member);
		$this->display();

  }

	// 客服换班
	public function shift_customer_service()
	{
		$this->check_login();
		$Member = M('Member');
		$cs_status = $this->member['cs_status'];
		$data['status']  = 1;

    $this->member['cs_status'] = ( $cs_status == 0 ?  1 : 0);

		$Member->save($this->member);

    $data['member'] = array('cs_status'=> $this->member['cs_status'] );
		$this->ajaxReturn($data);

	}
	// 发送手机验证码
	// ajax 请求
	public function send_vcode()
	{
		$mobile = I('mobile');
		//$mobile = '13322280797';
		$code = 0;
		$data['status']  = 1;
		$config = C('ALIYUN_SMS');
    //https://github.com/edoger/aliyun-sms-sdk
		$aliSms = new AliSms();
 		// Create model instanse.
		if( !$config['disable'] )
		{
			$code = mt_rand(1000, 9999);
 			// Send message.
			$response = $aliSms->send($mobile, 'SMS_76350172', ['number'=> $code]);

			//Log::write( print_r($response,true) );

			if( $response->Code != 'OK')
			{
				$code = 0;
			}
 		}else {
 			 $code = 9999;
		}
		if( $code > 0 )
		{
			//Log::write("yes, 2".$code);
			$sms_data = ['vcode'=>$code, 'mobile'=>$mobile, 'created_at'=>time() ];
			//Log::write( print_r($sms_data,true) );
			session('sms_data',$sms_data);
		}else {
			$data['status']  = 0;
		}

		$this->ajaxReturn($data);
		//$this->ajaxReturn('1','添加信息成功',1);
	}



  //测试代码
	public function test_jihuo()
	{
		var_dump( $this->exe_path );
		$machine_code = I('machine_code', '1234567890');
		$cmd = $this->exe_path.' TongYou '.$machine_code;
		exec($cmd, $arr);
		var_dump( $arr );
		$info = $arr[0];
		$this->assign('info',$info);
		$this->display('jihuo');
	}

	public function test_link()
	{
		$options = C('EASY_WECHAT');
		$app = new Application( $options);
		$js = $app->js;
		$this->assign('js',$js);
		$this->display( );
	}
	protected function check_login(){
		//session('mid',2);
		if( session('mid') == null){
			$this->error('您还没有登录！',U('/Home/Session/'));
		}
		$Member = M('Member');
		$AuthGroupAccess  = M('AuthGroupAccess');
		$this->member = $Member->where('id=%d', array(session('mid')))->find();

		//Log::write( print_r($this->member,true) );

		if( $this->member == null)
		{
			session('mid', null);
			$this->error('您还没有登录！',U('/Home/Session/'));
		}

		//$this->auth_group_access = $AuthGroupAccess->where('uid=%d', array( $this->member['id']))->find();

	}
}
