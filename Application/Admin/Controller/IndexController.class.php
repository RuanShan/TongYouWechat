<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class IndexController extends CommonController {
	public function index(){
		
		//菜单选中变色
		session('menu.module','index');
		
		//模板
		$this->display();
	}
}