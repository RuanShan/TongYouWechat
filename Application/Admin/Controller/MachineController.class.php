<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class MachineController extends CommonController {
	public function index(){
		$Category = M('Category');
		$Member          = M('Member');
		$Machine   = M('Machine');

		//查询条件
		$condition = array();
		$payment_status = I('payment_status', -1);
		if( $payment_status >=0 )
		{
			$condition['payment_status'] = $payment_status;
		}


		$count      = $Machine->where($condition)->count();
		$Page       = new \Think\Page($count,12);

		$list = $Machine->where($condition)->order('created_at desc')->limit($Page->firstRow.','.$Page->listRows)->select();

		$member_ids = [];
		foreach ($list as $key=> $val) {
			if( $val['customer_id'] > 0){
				$member_ids[] =  $val['customer_id'];
			}
			if( $val['engineer_id'] > 0){
				$member_ids[] =  $val['engineer_id'];
			}
		}
		if(!empty($member_ids))
		{
      $members = $Member->where(array('id'=>array('in',$member_ids)))->select();
	  }
		//分页信息
		$p = I('p', 1);
		$show       = $Page->show();

		$categories = $Category->select();
		$this->assign('p',$p);
		$this->assign('payment_status',$payment_status);

		$this->assign('categories',$categories);
		$this->assign('members',$members);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display('index');

	}

	public function post(){
		$Machine   = M('Machine');

		$p = I('p', 1);
		$data = array(
			'id' => I('id'),
			'payment_status'   => I('payment_status'),
		);
		$result = $Machine->save($data);
		if($result){
			$this->redirect('index', array('p' => $p), 0, '页面跳转中...');
		}else{
			$this->error('修改失败！');
		}
  }


	public function listz(){
		var_dump("abc");
		$this->display();
  }
}
