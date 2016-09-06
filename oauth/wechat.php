<?
 
/*
$GLOBALS['wechat_appid'] = 'wx33b752f7ad7c8890';
$GLOBALS['wechat_appsecret'] = 'f12e7300e4cdddb98442ad12802b2901';
 */
 

 require_once(ROOT.'/public/weixin/weixin.config.php');
 
if(!$GLOBALS['wechat_appid'] ) 
{ 
	return 'normal';	
}

if($_GET['refreshopenid'] =='force'){
	refreshOpenid();	
	
}else if( $_GET['state'] !='WEIXINCALLBACK')
//else if($_GET['state'] !='WEIXINCALLBACK')
{   
	refreshOpenid();	
}


if($_GET['state'] =='WEIXINCALLBACK')
{   
	if($_GET['code']){
	   $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?'
	         .'appid='. $GLOBALS['wechat_appid'] 
	         .'&secret='.$GLOBALS['wechat_appsecret']
	         .'&code=' .$_GET['code']
	         .'&grant_type=authorization_code';
	   
	    
	   require_once(ROOT.'/public/HTTP.php');  
	   $buf = http($url);  
	   $json=json_decode($buf);
	
	   //exit();
	   $_SESSION['openid'] = $json->openid;
	   
	   	require_once('oauth.php');
	    oauth($_SESSION['openid'], '微信用户','wechat');
	   
	   $GLOBALS['openid_refreshed'] = 'YES';
	}
}


function refreshOpenid(){
	
	$myurl = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"].'?'.$_SERVER["QUERY_STRING"];
	$myurl = str_replace('refreshopenid','unrefreshopenid',$myurl);

	$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?'
	.'appid=' . $GLOBALS['wechat_appid'] 	
	.'&redirect_uri=' .urlencode($myurl)
	.'&response_type=code&scope=snsapi_base&state=WEIXINCALLBACK#wechat_redirect' ;
	
		
	 header ('Location: '.$url);
   //	  echo "<a href='$url'>test:</a> <br>";
	// print_r($_SESSION);
	//  exit($myurl);
	exit;
}