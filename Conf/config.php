<?php
//项目配置
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'=>'mysql',
  'DB_HOST'=>'localhost',
  'DB_USER'=>'root',
  'DB_PWD'=>'33078233',
  'DB_PORT'=>'3306',
	#本项目数据库
  'DB_NAME'=>'ksw',
  #数据库表前缀
  'DB_PREFIX'=>'eve_',
  
  #EVE数据库
  'DB_CONFIG_EVE'=>array(
  	'DB_TYPE'=>'mysql',
  	'DB_HOST'=>'localhost',
  	'DB_USER'=>'root',
  	'DB_PWD'=>'33078233',
  	'DB_PORT'=>'3306',
  	'DB_NAME'=>'eve',
  ),
  /* 
  #External Hosting/外部数据库
  #dump version: inc110, 
	'DB_CONFIG_EVE'=>array(
  	'DB_TYPE'=>'mysql',
  	'DB_HOST'=>'db.descention.net',
  	'DB_USER'=>'evedump',
  	'DB_PWD'=>'evedump1234',
  	'DB_PORT'=>'3306',
  	'DB_NAME'=>'eve',
  ),
  */
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