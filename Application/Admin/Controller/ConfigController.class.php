<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class ConfigController extends CommonController {
	public function index(){
		//菜单选中变色
		session('menu.module','config');
		
		$Config = M('Config');
		$data = $Config->where('id=1')->find();
		
		$this->assign('data',$data);
		
		$this->display();
	}
	public function update(){
		$Config = M('Config');
		
		$data = array(
			'id'          => I('id'),
			'name'        => I('name'),
			'keywords'    => I('keywords'),
			'description' => I('description'),
		);
		
		$result = $Config->save($data);
		if($result) {
			$this->success('操作成功！');
		}else{
			$this->error('没有进行修改！');
		}
	}
}