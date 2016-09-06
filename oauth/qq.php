<?
session_start();
require_once("qq/API/qqConnectAPI.php");

if($_GET['act']=='gologin')
{
	goLogin();
}else{
	doLogin();

}

function doLogin()
{
	
	$qc = new QC();
	$accesskey = $qc->qq_callback();
	
	$openid = $qc->get_openid();
	
	 
	$qc = new QC($accesskey,$openid);
	//$openarr = $qc->get_user_info();
	 $openarr = $qc->get_user_info();
	
	
	require_once('oauth.php');
	oauth($openid, $openarr["nickname"],'QQ');
	header('Location: ../?win=user');
}

function goLogin(){
	$qc = new QC();
  $qc->qq_login();
	
}
 

?>