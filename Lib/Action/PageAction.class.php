<?php
//php 文件
//页面核心模块输出类
class PageAction extends Action{
	//禁止直接访问
	public function _initialize(){		
//		if('main'!==$this->from )	$this->errorpage();		
	}
	//不用assign参数的页面
	public function _empty($method,$args){
		if(file_exists_case(TMPL_PATH.'Page/'.$method.'.html')){
			$this->display(TMPL_PATH.'Page/'.$method.'.html');
		}
	}	
	//不存在页面
	public function errorpage(){
		Redirect(U('main/err404'));
	}	
}
?>