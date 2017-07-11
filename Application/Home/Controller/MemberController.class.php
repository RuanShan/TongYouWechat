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
		$telephone = I('telephone');
		$code = I('vcode');

		$data = array(
			'openid' => I('openid'),
			'group_id' => I('group_id'),
			'username'  => I('username'),
			'telephone' => I('telephone'),
			'address' => I('address'),
			'password' => md5(I('password')),
		);

		$user_info = $Member->where("telephone='%s'", array($data['telephone'] ) )->find();

		if(!$user_info){
			if($this->validate_vcode($telephone, $code))
			{
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
				$this->error('验证码错误！');
			}
		}else{
			//用户已存在，去登录
			$this->error('手机号码已注册，请登录!');
		}
	}

	//客户注册页面
	public function test_index(){

		$address = '大连沙河口';
		$member = [ 'openid'=>'testopenid', 'username'=> 'testnickname', 'address'=>$address ];
		$this->assign('member', $member);
		$this->display('index');
	}

}
