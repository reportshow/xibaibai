<?php
/*
http://localhost/?win=xxx&sub=ffff&func=cccc
http://localhost/?act=xxx&sub=ffff&func=aaa

*/
global $APP_WIN,$APP_MOD,$APP_SUB;
global $APP_TEMPLATE,$_TEMPLATE_;
$APP_WIN = $_REQUEST['win'];
$APP_ACT = $_REQUEST['act'];

//this 2 for customer
$APP_MOD = $_REQUEST['mod'];
$APP_SUB = $_REQUEST['sub'];


 


if(!$APP_TEMPLATE) $APP_TEMPLATE = 'default';
if(!$APP_WIN && !$APP_ACT) $APP_WIN = 'index'; 
if(!$APP_MOD) $APP_MOD = 'index'; 
if(!$APP_SUB) $APP_SUB = 'index'; 

$APP_TEMPLATE ='';

if($APP_WIN){
	$_TEMPLATE_ ="view/$APP_TEMPLATE";
	$WIN_VIEW_FILE= "view/$APP_TEMPLATE/$APP_WIN.htm";
	$ACT_EXEC_FILE =  "act/$APP_WIN.view.php";
}else if($APP_ACT) {
    $ACT_EXEC_FILE =  "act/$APP_ACT.php";
}

$rootlongpath=realpath('./'); 
$longpath1=realpath($ACT_EXEC_FILE);  $longpath2=realpath($WIN_VIEW_FILE);  
if(  ($longpath1 && strpos('-'.$longpath1,$rootlongpath) < 1)  
     ||   ($longpath1 && strpos('-'.$longpath2,$rootlongpath) < 1 ) 
   ){
	echo $longpath2;
	echo strpos('-'.$rootlongpath,$longpath1) .']]';
	exit("url param error.");	
}


/* action */
if(is_file($ACT_EXEC_FILE))  {;
	require_once($ACT_EXEC_FILE);	
	$func = 'do_'.$_REQUEST['func'];
	if(function_exists($func)){
		$func();
	}
 }
 
 /* display */
if($WIN_VIEW_FILE && is_file($WIN_VIEW_FILE)) { 
	;require_once($WIN_VIEW_FILE);	
	
}