<?php
namespace Home\Controller;
use Home\Common\Controller\CommonController;
use EasyWeChat\Foundation\Application;
use Think\Log;

class SessionController extends WechatBaseController {
	//登陆页面
	public function index(){
		$Config     = M('Config');
		//配置
		$config_data = $Config->where('id=1')->find();
		$this->assign('config_data',$config_data);

		$app = new Application($this->options);

		$this->display();
	}

	//登陆处理
	public function login(){

		$Member     = M('Member');

		$data = array(
			'password'  => md5(I('password')),
			'telephone' => I('telephone'),
		);

		$result = $Member->where($data)->find();
		Log::write( print_r($result,true) );

		if($result){

			if($result['status'] == 0){
				$this->error('登录失败，账号被禁用',U('index'));
			}
			session('mid',$result['id']);	//用户ID
			session('username',$result['username']);	//用户名
			//保存登录信息
			$data['id'] = $result['id'];	//用户ID
			$data['login_ip'] = get_client_ip();	//最后登录IP
			$data['login_time'] = date('Y-m-d H:i:s');		//最后登录时间
			$data['login_count'] = $result['login_count'] + 1;
			$Member->save($data);
			$this->redirect( '/Home/Index/index');
		}else{
			$this->error('登录失败，账号密码不匹配。',U('index'));
			//$this->redirect('index');
		}
	}


}
