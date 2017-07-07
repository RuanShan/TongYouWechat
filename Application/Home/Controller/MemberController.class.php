<?php
namespace Home\Controller;
use Think\Log;
use EasyWeChat\Foundation\Application;

class MemberController extends WechatBaseController {

	//客户注册页面
	public function index(){
		$Config     = M('Config');
		$config_data = $Config->where('id=1')->find();
		$this->assign('config_data',$config_data);

		$app = new Application($this->options);
		$oauth = $app->oauth;
		// 未登录
		if (empty(session('wechat_user'))) {
			session('target_url', '/home/member/index');
			$response = $oauth->scopes(['snsapi_userinfo'])->redirect();
			// $user 可以用的方法:
			// $user->getId();  // 对应微信的 OPENID
			// $user->getNickname(); // 对应微信的 nickname
			// $user->getName(); // 对应微信的 nickname
			// $user->getAvatar(); // 头像网址
			// $user->getOriginal(); // 原始API返回的结果
			// $user->getToken(); // access_token， 比如用于地址共享时使用
			$response->send();
			//var_dump($response);

		}
		$user = session('wechat_user');
		$address = $user['original']['country'].$user['original']['province'].$user['original']['city'];
		$member = [ 'openid'=>$user['id'], 'username'=> $user['nickname'], 'address'=>$address ];
		var_dump( $user);
		$this->assign('member', $member);
		$this->display();
	}

	public function oauth_callback()
	{
			$app = new Application($this->options);
			$oauth = $app->oauth;
			$user = $oauth->user();

			session('wechat_user', $user->toArray());
			$targetUrl = empty(session('target_url')) ? '/' : session('target_url');
			header('location:'. $targetUrl); // 跳转到 user/profile
	}

	//创建客户
	public function create(){

		$Member     = M('Member');
		$AuthGroupAccess     = M('AuthGroupAccess');
		Log::write( print_r($_POST, true ));
		//[group_id] => 1
    //[username] => testnickname
    //[telephone] => 13812345678
    //[vcode] => 123456
    //[password] => abcdef
    //[address] => 大连沙河口

		$data = array(
			'openid' => I('openid'),
			'group_id' => I('group_id'),
			'username'  => I('username'),
			'telephone' => I('telephone'),
			'address' => I('address'),
			'password' => md5(I('password')),
		);

		$user_info = $Member->where("username='%s' AND telephone='%s'", array($data.username, $data.telephone ) )->find();

		if(!$user_info){
			$result = $Member->add($data);
			if($result) {
				$access_data = array(
					'uid'      => $result,
					'group_id' => I('group_id')
				);

				$access_result = $AuthGroupAccess->add($access_data);

				if($access_result) {
					session('mid', $result.id);
					$this->redirect('/Home/Index');
				}else{
					$this->error('操作失败！');
				}

			}else{
				$this->error('操作失败！');
			}
		}else{
			//用户已存在，去登录
			$this->redirect('/Home/Session');
		}
	}

	//客户注册页面
	public function test_index(){

		$address = '大连沙河口';
		$member = [ 'openid'=>'testopenid', 'username'=> 'testnickname', 'address'=>$address ];
		$this->assign('member', $member);
		$this->display('index');
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

}
