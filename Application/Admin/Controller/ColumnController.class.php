<?php
namespace Admin\Controller;
use Admin\Common\CommonController;
class ColumnController extends CommonController {
	public function form($type,$id=0){	
		if($type=='edit'){
			$Column = M('Column');
			$data = $Column->where('id='.$id)->find();
			$this->assign('data',$data);
		}
		$this->display();
	}
	public function post(){
		$Column = M('Column');
		
		$data = array(
			'name'         => I('name'),
			'en_name'      => I('en_name'),
			'other_en'     => I('other_en'),
			'keywords'     => I('keywords'),
			'descriptions' => I('descriptions'),
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
					$pic[$key] = $Column->where('id='.I('id'))->getField($key);
					@unlink('./Uploads/'.$pic[$key]);
				}
			}
		}
		
		if(I('id')){
			$data['id'] = I('id');
			$result = $Column->save($data);
			if($result){
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
			}
		}else{
			$data['pid'] = I('pid');
			$result = $Column->add($data);
			if($result){
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！');
			}
		}
	}
}