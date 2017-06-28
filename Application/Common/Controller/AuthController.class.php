<?php
namespace Common\Controller;
use Think\Controller;
class AuthController extends Controller {
		public function _initialize () {
				if(!session('uid')){
					redirect(__ROOT__.'/');
				}
				$AUTH = new \Think\Auth();
				
				if(session('uid')!=1){
					//类库位置应该位于ThinkPHP\Library\Think\
					if(!$AUTH->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME, session('uid'))){
							$this->error('没有权限',U('Login/logout'));
							//$this->redirect('Login/logout');
					}
				}
				//侧边列表
				$this->side_list();
		}
}