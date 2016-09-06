<?php
session_start();

include_once( 'weibo/config.php' );
include_once( 'weibo/saetv2.ex.class.php' );


if($_GET['act']=='gologin')
{
	goLogin();
}else{
	doLogin();

}

function doLogin(){
	
	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
	
	if (isset($_REQUEST['code'])) {
		$keys = array();
		$keys['code'] = $_REQUEST['code'];
		$keys['redirect_uri'] = WB_CALLBACK_URL;
		try {
			$token = $o->getAccessToken( 'code', $keys ) ;
		} catch (OAuthException $e) {
		}
	}
	
	 
	
	if ($token) {
		$_SESSION['token'] = $token;
	 // setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	  
	  $c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
		//$ms  = $c->home_timeline(); // done
		$uid_get = $c->get_uid();
		$openid = $uid_get['uid'];
		$user_info = $c->show_user_by_id( $openid);//根据ID获取用户等基本信息
		 
	 require_once('oauth.php');
	 oauth($openid, $user_info["name"],'WEIBO');
	header('Location: ../?win=user');
	
	
	}

}


function goLogin(){
	$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
  $code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
	header('Location: '.$code_url);
}
?>
 