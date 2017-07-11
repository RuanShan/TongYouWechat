<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;

class CategoryController extends CommonController {
	public function index(){
		redirect(U('Category/lists'));
	}
	public function lists(){
		$Category = M('Category');

		$count      = $Category->count();
		$Page       = new \Think\Page($count,25);
		$show       = $Page->show();

		$list = $Category->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);

		$this->display();
	}

	public function form( $type, $id=0){
		$this->assign('type',$type);

		if($type=='edit'){
			$Category = M('Category');
			$data = $Category->where('id='.$id)->find();
			$this->assign('data',$data);
		}
		$this->display();
	}
	public function post($type){
		$Category = M('Category');

		if(!I('title')){
			$this->error('标题不为空！');
		}

		$data = array(
			'title'        => I('title'),
			'desc'        => I('desc'),
			'position'        => I('position'),

		);

		if($type=='add'){

			$result = $Category->add($data);
			if($result){
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！');
			}
		}else if($type=='edit'){

			$data['id'] = I('id');
			$result = $Category->save($data);
			if($result){
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
			}
		}
	}
	public function delete(){
		$Category = M('Category');

		$result = $Category->delete(I('id'));
		if($result){
			$this->success('删除成功！');
		}
	}
}
