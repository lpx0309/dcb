<?php 
//链接根路径
if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
	define('LINK_ROOT','http://localhost/dcb3');
}else{
	define('LINK_ROOT','http://'.str_replace($_SERVER['DOCUMENT_ROOT'],$_SERVER['HTTP_HOST'],str_replace("\\","/",FILE_ROOT)));
}

//数据库
define('_DB_SERVER_', '123.57.220.98');
define('_DB_NAME_', 'dcb');
define('_DB_USER_', 'admin');
define('_DB_PASSWD_', 'lpxsdb!@#$');
define('_DB_PREFIX_', 'dcb_');
//时区
date_default_timezone_set("Asia/Shanghai");
//页面编码
header("Content-Type:text/html;charset=utf-8");
?>