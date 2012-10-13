<?php
//项目配置
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'=>'mysql',
# LocalHost

  'DB_HOST'=>'localhost',
  'DB_NAME'=>'eve',
  'DB_USER'=>'root',
  'DB_PWD'=>'33078233',
  'DB_PORT'=>'3306',


 #
  'DB_PREFIX'=>'',
	'URL_CASE_INSENSITIVE' =>true,
	'DEFAULT_MODULE' =>	'main',
	'DEFAULT_ACTION' => 'index',
	"LOAD_EXT_FILE"=>"extend"	,		//加载自定义函数库
	
	//cookie设置
	'COOKIE_PW' => "x8ad4adsa13",
	'COOKIE_PREFIX'=>'eve',
	
//	'TMPL_PARSE_STRING'  =>array('__PUBLIC__' => './Tpl',),
	);
?>