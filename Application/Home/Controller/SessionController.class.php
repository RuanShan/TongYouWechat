<?php
namespace Home\Controller;
use Home\Common\Controller\CommonController;
use EasyWeChat\Foundation\Application;
use Think\Log;

class SessionController extends WechatBaseController {
	//登陆页面
	public function index(){
		$Config     = M('Config');
		$Member = M('Member');

		//配置
		$config_data = $Config->where('id=1')->find();
		$this->assign('config_data',$config_data);

		$app = new Application($this->options);
		$oauth = $app->oauth;
		// 未登录
		if (empty(session('wechat_user'))) {
			session('target_url', '/home/session/index');
			$response = $oauth->scopes(['snsapi_userinfo'])->redirect();
			// $user 可以用的方法:
			// $user->getId();  // 对应微信的 OPENID
			// $user->getNickname(); // 对应微信的 nickname
			// $user->getName(); // 对应微信的 nickname
			// $user->getAvatar(); // 头像网址
			// $user->getOriginal(); // 原始API返回的结果
			// $user->getToken(); // access_token， 比如用于地址共享时使用
			$response->send();

		}
		$user = session('wechat_user');
		//var_dump($user);
		$address = $user['original']['country'].$user['original']['province'].$user['original']['city'];

		$member = $Member->where( array('openid'=>$user['id']))->find();

		//查找用户openid，确认用户是否注册
		if( !$member )
		{
			$member = [ 'openid'=>$user['id'], 'username'=> $user['nickname'], 'address'=>$address, 'headimgurl'=>$user['avatar']  ];
		}
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

	//登陆处理
	public function login(){
		$Member     = M('Member');
		$cond = array(
			//这里根据openid查找， 以便用户更新电话
			'openid' => I('openid'),
		);
		$telephone = I('telephone');
		$code = I('vcode');

		$result = $Member->where($cond)->find();
		Log::write( print_r($result,true) );

		//客户没有注册，创建客户。
		if( !$result)
		{
			if($this->validate_vcode($telephone, $code))
			{
				Log::write( "yes, i am here" );
				$data = array(
					'openid' => I('openid'),
					'headimgurl' => I('headimgurl'),
					'status' => 1,
					'group_id' => 1,
					'username'  => I('username'),
					'telephone' => I('telephone'),
					'address' => I('address'),
				);
				$Member->data($data)->add();

				$result = $Member->where($cond)->find();

			}else{
				$this->error('登录失败，验证码不正确。',U('index'));
			}
		}

			if($result['status'] == 0){
				$this->error('登录失败，账号被禁用',U('index'));
			}

			if($this->validate_vcode($telephone, $code))
			{
				session('mid',$result['id']);	//用户ID
				session('username',$result['username']);	//用户名
				//保存登录信息
				$data['id'] = $result['id'];	//用户ID
				$data['login_ip'] = get_client_ip();	//最后登录IP
				$data['login_time'] = date('Y-m-d H:i:s');		//最后登录时间
				$data['login_count'] = $result['login_count'] + 1;
				$data['telephone'] = $telephone; //更新电话号码
				$Member->save($data);
				$this->redirect( '/Home/Index/index');
			}else {
				$this->error('登录失败，验证码不正确。',U('index'));
			}

	}


}
