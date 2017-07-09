<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class UserController extends CommonController {


	public function lists(){
		$AuthGroup = M('AuthGroup');
		$AuthGroupAccess = M('AuthGroupAccess');
		$Member          = M('Member');

		$map = [];
		if( !empty(I('group_id')))
		{
			$map['group_id'] = I('group_id');
		}

    $groups = $AuthGroup->select();
		$count      = $Member->where( $map )->count();
		$Page       = new \Think\Page($count,12);
		//分页跳转的时候保证查询条件
		foreach($map as $key=>$val) {
		    $Page->parameter[$key]   =   urlencode($val);
		}
		$show       = $Page->show();
 		$list = $Member->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

		$p = I('p', 1);

		$this->assign('p',$p);
		$this->assign('groups',$groups);
		$this->assign('list',$list);
		$this->assign('page',$show);


		//模板
		$this->display();
	}

	public function form($id=0){
		$p = I('p', 1);
		$group_id = I('group_id', 0);
		$this->assign('group_id',$group_id);
		$this->assign('p',$p);

		$AuthGroup = M('AuthGroup');
		{
			$Member = M('Member');
			$groups = $AuthGroup->select();
			$data = $Member->where('id='.$id)->find();

			$status_enum = array([ 'id'=>0, 'name'=>'禁用'], ['id'=>1, 'name'=>'正常']);
			$this->assign('status_enum',$status_enum);
			$this->assign('groups',$groups);
			$this->assign('data',$data);
		}
		$this->display();
	}
	public function post($type){
		$Member = M('Member');

		$data = array(
			'status'   => I('post.status'),
			'group_id'   => I('post.group_id')
		);


		if($type=='add'){

			$result = $Member->add($data);
			if($result){
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！');
			}
		}else if($type=='edit'){

			$data['id'] = I('id');
			$result = $Member->save($data);
			if($result){
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
			}
		}
	}
	public function delete(){
		$Member = M('Member');
		if( I('id') == 1)
		{
			$this->error('禁止删除超级管理员！');
		}

		$result = $Member->delete(I('id'));
		if($result){
			$this->success('删除成功！',U('lists'));
		}
	}

}
