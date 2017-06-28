<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class AdminPassWordController extends CommonController {
    public function index(){
        $this->display();
    }
		public function update(){
        $Member = M('Member');
				$result = $Member->where('password=\''.md5(I('password')).'\' AND username=\''.session('username').'\'')->find();
				if($result){
					if(I('newpassword')!=I('repassword')){
					}
					$data = array(
						'password' => md5(I('newpassword'))
					);
					$result = $Member->where('password=\''.md5(I('password')).'\' AND username=\''.session('username').'\'')->save($data);
					if($result){
						$this->success('密码修改成功！请重新登录！',U('Login/logout'));	
					}else{
						$this->error('密码修改失败！',U('AdminPassWord/index'));;	
					}
				}else{
					$this->error('旧密码输入错误！',U('AdminPassWord/index'));
				}
    }
}