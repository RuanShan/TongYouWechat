<?php
namespace Admin\Controller;
use Home\Common\Controller\CommonController;
class OrderController extends CommonController {
	public function index(){
		$Member          = M('Member');
		$Machine   = M('Machine');
		$count      = $Machine->count();
		$Page       = new \Think\Page($count,12);

		$list = $Machine->limit($Page->firstRow.','.$Page->listRows)->select();

		$member_ids = [];
		foreach ($list as $key=> $val) {
			if( $val['customer_id'] > 0){
				$member_ids[] =  $val['customer_id'];
			}
			if( $val['engineer_id'] > 0){
				$member_ids[] =  $val['engineer_id'];
			}
		}
    $members = $Member->where(array('id'=>array('in',$member_ids)))->select();

		$this->assign('members',$members);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display();

	}


}
