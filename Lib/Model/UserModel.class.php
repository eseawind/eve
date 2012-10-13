<?php
//php 文件
class UserModel extends Model {
	protected	$tableName	=	'user';
	
	public function getUserInfo($identifier, $identifier_type = 'uid'){
		if ($identifier_type == 'uid' && !is_numeric($identifier))
			return false;
		else if (!in_array($identifier_type, array('uid','uname')))
			return false;
		$user = $this->_getUserInfo($identifier, $identifier_type);
		return $user;
	}
	private function _getUserInfo($identifier, $identifier_type){
		if(strtolower($identifier_type)=='uname') $identifier_type='User';
		return $this->where("{$identifier_type}='{$identifier}'")->find();
	}
	public function login($uname,$password){
		$map="user='{$uname}' and pw='".md5(sha1($password))."'";
		if($this->where($map)->find()){
			return $this->getUserInfo($uname,'uname');
		}else{
			return false;
		}
	}
}
?>