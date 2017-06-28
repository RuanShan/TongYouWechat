<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function index(){
		redirect(U('Login/login'));
	}
  //登录验证
	public function login(){
		if(session('uid')){
			$this->error('已登录，正在跳转到后台主页',U('Index/index'));
		}
		$this->display();
	}
	public function checklogin(){
		$map['username'] = I('username');   //用户名
		$map['password'] = md5(I('password'));	//密码
		$Member = M('Member');
		$result = $Member->where($map)->find();
		if($result){
			$Verify = new \Think\Verify();
			$Verify->seKey = 'liyingda';
			if(!$Verify->check(I('verify'))){
				$this->error('验证码错误！',U('Login/login'));
			}
			if($result['status'] == 0){
				$this->error('登录失败，账号被禁用',U('Login/login'));
			}
			session('uid',$result['id']);	//用户ID	
			session('username',$result['username']);	//用户名	
			//保存登录信息
			$data['id'] = $result['id'];	//用户ID
			$data['login_ip'] = get_client_ip();	//最后登录IP
			$data['login_time'] = date('Y-m-d H:i:s');		//最后登录时间
			$data['login_count'] = $result['login_count'] + 1;
			$Member->save($data);    				
			$this->success('验证成功，正在跳转到后台首页',U('Index/index'));	
		}else{
			$this->error('账户或密码错误',U('Login/login'));
		}
	}
	public function logout(){
		session(null);
		$this->success('退出成功！',U('Login/login'));			
	}
	//验证码
	public function verify(){   	
		ob_clean();		//清除缓存
		$Verify = new \Think\Verify();
		$Verify->seKey = 'liyingda';
		$Verify->fontSize = 30;	//验证码字体大小
		$Verify->length = 4;	//验证码位数
		$Verify->entry();
	}
}