<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class UserController extends CommonController {
	public function lists(){
		$AuthGroup = M('AuthGroup');
		$AuthGroupAccess = M('AuthGroupAccess');
		$Member          = M('Member');
		
		$group_data = $AuthGroup->where('id='.I('id'))->find();
		
		$this->assign('group_data',$group_data);
		
		$user_id = $AuthGroupAccess->where('group_id='.I('id'))->field('uid')->select();
		
		foreach($user_id as $key=>$val){
			$user_id_arr[] = $val['uid'];
		}
		
		$count      = $Member->where(array('id'=>array('in',$user_id_arr)))->count();
		$Page       = new \Think\Page($count,25);
		$show       = $Page->show();
		
		$list = $Member->order('id DESC')->where(array('id'=>array('in',$user_id_arr)))->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('list',$list);
		$this->assign('page',$show);
		
		
		//模板
		$this->display();
	}
}