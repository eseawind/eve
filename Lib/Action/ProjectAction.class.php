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
}
?>