<?php
//请用UltraEdit等工具 保存本文件为UTF-8无BOM 格式， 
//严重不推荐用 windows自带的'记事本'进行编辑. (除非本文中没有英文数字半角符号以外的任何字符)
 
//  error_reporting(0); //是否提示运行错误开关
 error_reporting(E_ALL & ~E_NOTICE);
 
 //--------------------请在这里配置您的 数据库 基本信息------------------------------
 global $db_host, $db_user, $db_password, $db_db, $tb_prefix;  

  
	$db_host      = "localhost";   //数据库服务器ip,域名, 如果和程序在一个机器,可填localhost

  if(!defined('ROOT')){
  	  require_once('global.php');
  }
  
  if(defined('DEBUG'))
  {  $db_user      = "root";        //帐号 
	$db_password  = "123456";    //密码
	$db_db        = "xibaibai";      //数据库名    
	$tb_prefix    = "xbb_";      //表前缀
 }else{
  
	$db_user      = "root";        //帐号 
	$db_password  = "quick";    //密码
	$db_db        = "ding_xibaibai";      //数据库名    
	$tb_prefix    = "xbb_";      //表前缀	
	
 }
 if($GLOBALS['site_code'])
 {
		$tb_prefix    = $GLOBALS['site_code'] ."_";      //表前缀	
 }
 
 
 
 /*   
    数据库名	数据库用户名	数据库密码	状态	管理入口	其他操作
    s574507db0	s574507db0	9fx9z5t5
*/
?>