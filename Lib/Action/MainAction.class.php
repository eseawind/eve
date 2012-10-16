<?php
//php 文件
class MainAction extends Action
{
		//+++++++++++++++++++++++++++++++++++++++++++++++++
		//初始化
		public function _initialize(){
			$this->_initUser();			//装载用户信息
			$this->from='main';
		}
 		private function _initUser(){
 			$this->mid = intval($_SESSION['mid']);
 			$_REQUEST['uid'] && $this->uid = $_REQUEST['uid'];
 		}		
 		
		//++++++++++++++++++++++++++++++++++++++++++++++++++
		//用户相关
		
		/*
		*登录页面
		*/
 		Public function Login(){
 			$this->assign('title','登录 - KSW高新产业部');
 			$this->display();
 		}
 		/*
 		*登录操作
 		*/
 		Public function doLogin(){
 			$_POST['username'] && $uname=$_POST['username'];
 			$_POST['password'] && $password=$_POST['password'];
 			if(!($uname && $password)) Redirect(U('Main/login'));
 			$user=D('User')->login($uname,$password);
 			if($user){
 				$this->recoder($user,$_POST['remember']);
 				Redirect(U('main/index'));
 			}else{
 				echo "账号密码错误";
 			}
 		}
 		/*
 		*记录登录状态
 		*/
 		private function recoder($user,$remember){
 			$this->mid=$user['uid'];
 			$_SESSION['mid']=$this->mid;
 			if($remember){
 				$cookie['uid']=$this->mid;
 				$cookie['ltime']=date();
 				cookie('Logged',jiami(serialize($cookie),C('COOKIE_PW')),1*30*24*60*60);		//保存cookie一个月
 			}
 		}
 		/*
 		*登出
 		*/
 		Public function logout(){
 			cookie();
 			unset($_SESSION['mid']);
 			Redirect(U('main/login'));
 		}
 		/*
 		*注册页面
 		*/
 		Public function register(){
 			$data['uid']=1;
 			$data['time']=234;
 			echo jiami(serialize($data),C('COOKIE_PW'),1*30*24*60*60);
 		}
 		/*
 		*注册操作
 		*/
 		Public function doregister(){
 		}
 		//++++++++++++++++++++++++++++++++++++++++++++++++++
 		//后台页面
    public function index(){
//	    if(!$this->mid){
//	 			Redirect(U('Main/login'));
//	 			exit();
//	 		}
			$this->assign('title','KSW高新产业公司 后台');
			if(!is_null($_REQUEST['item'])){
				$array=$this->Itemsplit($_REQUEST['item']);
				$query=D('Item');
				$items=$query->getItems($array);
				$this->assign('items',$items);
				
			}
   		$this->display();
 		}		
		
		protected function Itemsplit($string){
			$types=explode('+',$string);
			foreach($types as $type){
				if(trim($type)=="")
					continue;
				$tmp=explode('*',$type);
				$items[]=array('type'=>$tmp[0],'num'=>$tmp[1]);
			}
			return $items;
		}
 		
		public function err404(){
			$this->display();
		}
		public function test(){
			$query=D('Item');
			$a=$query->getPrice('34');
			//print_r($a);
		}
}
?>