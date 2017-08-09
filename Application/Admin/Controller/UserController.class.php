<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
use Think\Log;
use EasyWeChat\Foundation\Application;

class UserController extends CommonController {


	public function lists(){
		$AuthGroup = M('AuthGroup');
		$AuthGroupAccess = M('AuthGroupAccess');
		$Member          = M('Member');

		$map = [];
		if( empty(I('disable_filter')))
		{
			 $map = $this->buildCondition();
		}
		Log::write( print_r($map,true) );

		$hasFilter = (count($map) > 0);
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
		$this->assign('hasFilter',$hasFilter);
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
	public function post( ){
		$Member = M('Member');

		$data = array(
			'status'   => I('post.status'),
			'group_id'   => I('post.group_id')
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
					$path = './Uploads/'.$data[$key];
          $media_id = $this->uploadWeixin($path);
					$data['cs_media_id'] = $media_id;
				}
				if(I('id')){
					$pic[$key] = $Member->where('id='.I('id'))->getField($key);
					@unlink('./Uploads/'.$pic[$key]);
				}
			}
		}

			$data['id'] = I('id');
			$result = $Member->save($data);
			if($result){
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
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



	public function export(){
		$Member = M('Member');
		$Category = M('Category');
    $map = $this->buildCondition();

		$members = $Member->where( $map )->select();
		$categories = $Category->select();
		$member_ids = [];
		$exportData = [];
		foreach ($members as $key => $member) {
			$member_ids[] = $member['id'];
			$row = [ 'id'=>$member['id'],'username'=>$member['username'], 'telephone'=> $member['telephone'],'address'=> $member['address'],'created_at'=> $member['created_at']];

			foreach ($categories as $key => $category) {
				//初始化产品分类
				$row['c'.$category['id']] = 0;
      }
			$exportData[] = $row;

		}

		if( count($member_ids) > 0)
		{
			$ids = join(',', $member_ids);
 		  $order_sql = 'SELECT *, count(*) as order_count FROM   wx_order  where member_id in ('.$ids.') group by  member_id, category_id;';
		  $Model = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
			$orders = $Model->query($order_sql);
			foreach ($orders as $key => $order) {
				//http://www.cnblogs.com/yangwenxin/p/5845212.html
				foreach ($exportData as $key => &$row) {
					//Log::write( '--->'.$row['id'].'?'.$order['member_id']);

					if( $row['id']== $order['member_id'])
					{
 						$row['c'.$order['category_id']] = $order['order_count'];
 						break;
					}
				}
			}
	  }
		//Log::write( print_r($exportData,true) );

		//编号	姓名	电话	地区	产品1	产品2	产品3	产品4	产品5	产品6	产品7	产品8
    $col_names = [['id','编号'],	['username','姓名'],	['telephone','电话'],	['address','地区'],	['created_at','注册日期']];
		foreach ($categories as $key => $category) {
			$col_names[] = ['c'.$category['id'], $category['title']];
    }
		$title = I('from_date').'~'.I('to_date');
		$this->writeDataToXls( $title, $col_names, $exportData);
	}

	//
	public function buildCondition()
	{
		$map = [];
		if( !empty(I('group_id')) && I('group_id')>0)
		{
			$map['group_id'] = I('group_id');
		}
		if( !empty(I('from_date')) && !empty(I('to_date')))
		{
			$map['created_at'] =  array( array('egt',date('Y-m-d H:i:s',strtotime(I('from_date')))), array('elt',date('Y-m-d H:i:s',strtotime(I('to_date')))));
		}

		return $map;
	}

	public function uploadWeixin( $filePath )
	{
		$options = C('EASY_WECHAT');
		$app = new Application( $options);
		$material = $app->material;
		//$result = $material->uploadImage("./Uploads/cs/wechat/betester.png");
		$result = $material->uploadImage($filePath);
		// {
		//    "media_id":MEDIA_ID,
		//    "url":URL
		// }
		return $result['media_id'];
	}
}
