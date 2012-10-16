<?php
//php 文件
//Controller - 项目
class ProjectAction extends Action{
	public function Add(){
		$this->assign('title','新建项目');
		$this->display();
	}
	public function doAdd(){
	}
	public function getInfo(){
		$item=$_REQUEST['item'];
		$query=D('Item');
		echo json_encode($query->getInfo($item));
	}
}
?>