<?php 
require_once('global.php');

/*
global $APP_WIN,$APP_MOD,$APP_SUB;
global $APP_TEMPLATE,$_TEMPLATE_;
$APP_WIN = $_REQUEST['win'];
//this 2 for customer
$APP_MOD = $_REQUEST['mod'];
$APP_SUB = $_REQUEST['sub'];







if(!$APP_TEMPLATE) $APP_TEMPLATE = 'default';
if(!$APP_WIN) $APP_WIN = 'index'; 
if(!$APP_MOD) $APP_MOD = 'index'; 
if(!$APP_SUB) $APP_SUB = 'index'; 
 
$_TEMPLATE_ ="view/$APP_TEMPLATE";
$file_win = "view/$APP_TEMPLATE/$APP_WIN.htm";
$file_exec =  "act/$APP_WIN.php";

//var_dump($file_exec);
 

if(is_file($file_exec))  {;
	require_once($file_exec);	
	$func = 'do_'.$_REQUEST['func'];
	if(function_exists($func)){
		$func();
	}
 }
 
 
if(is_file($file_win)) {  
	;require_once($file_win);	
	
}


*/
exit;


