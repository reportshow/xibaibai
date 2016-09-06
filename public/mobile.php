<?  


if(MOBILE_LOGIN && ismobile())
{
   $APP_TEMPLATE = 'mobile';
 
 
   //mobile user login 
	if(!$_SESSION['user_id'])
	{
		$isnormal = 'normal';
		$usertype = 'mobile';
		 if(strpos($_SERVER['HTTP_X_REQUESTED_WITH'],'tencent.mm')
		||  strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger'))
		{   
		    $isnormal = require_once(ROOT. 'oauth/wechat.php');	  
		    $usertype= 'wechat';
		}else if(strpos($_SERVER['HTTP_X_REQUESTED_WITH'],'com.tencent.mobileqq')
		|| strpos($_SERVER['HTTP_USER_AGENT'],'QQ'))
		{
		  $url = 'oauth/qq.php?act=gologin';
		  header('Location: '.$url);	
		  exit;
		} 
		
		if($isnormal=='normal')
		{
			//echo "<h1>测试</h1>";
			require_once(ROOT.'/oauth/oauth.php');
			if($_COOKIE['sweet_rndid'])
			{  $openid = $_COOKIE['sweet_rndid'];
		    }else{
			   $openid  = 'rnd' . time() . rand(1000,9999);
			   setcookie('sweet_rndid',$openid, time()+3600*24*300);
		    }
		    oauth($openid, 'mobile', $usertype);
	     }
		
	}



}


function ismobile(){
	if(defined('FORCE_MOBILE') )  return true;
	
	
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);

	$uachar = "/(android|micromessenger|qq|nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";

	if(($ua == '' || preg_match($uachar, $ua))&& !strpos(strtolower($_SERVER['REQUEST_URI']),'wap'))
	{ 
	  return true;
	}else
	{  return false;
	}
}