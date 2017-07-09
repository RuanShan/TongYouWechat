<?php
namespace Admin\Controller;
use Admin\Common\CommonController;
class ArticleController extends CommonController {
	public function index(){
		redirect(U('Article/lists'));
	}
	public function lists($column_id){
		$Article = M('Article');
		$Column = M('Column');
		
		$column_data = $Column->where('id='.$column_id)->find();
		
		$this->assign('column_data',$column_data);
		
		$count      = $Article->where('column_id='.$column_id)->count();
		$Page       = new \Think\Page($count,25);
		$show       = $Page->show();
		
		$list = $Article->order('id DESC')->where('column_id='.$column_id)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);
		
		$this->display();
	}
	public function form($type,$column_id=0,$id=0){
		$Column = M('Column');
		$column_data = $Column->where('id='.$column_id)->find();
		$column_big_data = $Column->where('id='.$column_data['pid'])->find();
		
		if($column_big_data['pid']){
			$column_big_big_data = $Column->where('id='.$column_big_data['pid'])->find();
		}
		
		$this->assign('column_big_big_data',$column_big_big_data);
		
		$this->assign('column_data',$column_data);
		
		if($type=='edit'){
			$Article = M('Article');
			$data = $Article->where('id='.$id)->find();
			$data['content'] = stripslashes(htmlspecialchars_decode($data['content']));
			$data['direction'] = stripslashes(htmlspecialchars_decode($data['direction']));
			$data['course'] = stripslashes(htmlspecialchars_decode($data['course']));
			$data['obtain'] = stripslashes(htmlspecialchars_decode($data['obtain']));
			$data['enterprise'] = stripslashes(htmlspecialchars_decode($data['enterprise']));
			
			$this->assign('data',$data);
		}
		$this->display();
	}
	public function post($type){
		$Article = M('Article');
		
		if(!I('title')){
			$this->error('文章标题不为空！');
		}
		
		$data = array(
			'column_id'    => I('column_id'),
			'title'        => I('title'),
			'title_en'     => I('title_en'),
			'post_time'    => I('post_time').' '.date('H:i:s'),
			'keywords'     => I('keywords'),
			'descriptions' => I('descriptions'),
			'source'       => I('source'),
			'content'      => I('content'),
			'direction'    => I('direction'),
			'course'       => I('course'),
			'obtain'       => I('obtain'),
			'enterprise'   => I('enterprise'),
		);
		
		foreach($_FILES as $key=>$val){
			if($_FILES[$key]['name']!=''){
				$upload = new \Think\Upload();// 实例化上传类
				$upload->maxSize   =     3145728 ;// 设置附件上传大小
				$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
				
				/*$image = new \Think\Image(); 
				$image->open($_FILES[$key]['tmp_name']);
				$image->thumb(600, 500)->save($_FILES[$key]['tmp_name']);*/
				
				// 上传单个文件 
				$info   =   $upload->uploadOne($_FILES[$key]);
				if(!$info) {// 上传错误提示错误信息
					$this->error($upload->getError());
				}else{// 上传成功 获取上传文件信息
					$data[$key] = $info['savepath'].$info['savename'];
				}
				if(I('id')){
					$pic[$key] = $Article->where('id='.I('id'))->getField($key);
					@unlink('./Uploads/'.$pic[$key]);
				}
			}
		}
		
		if($type=='add'){
			
			$result = $Article->add($data);
			if($result){
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！');
			}
		}else if($type=='edit'){
			if($_FILES['thumb']['name']!=''){
				$thumb = $Article->where('id='.I('id'))->getField('thumb');
				@unlink('./Uploads/'.$thumb);
			}
			
			$data['id'] = I('id');
			$result = $Article->save($data);
			if($result){
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
			}
		}
	}
	public function delete(){
		$Article = M('Article');
		$thumb = $Article->where('id='.I('id'))->getField('thumb');
		@unlink('./Uploads/'.$thumb);
		$result = $Article->delete(I('id'));
		if($result){
			$this->success('删除成功！');
		}
	}
}