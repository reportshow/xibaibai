<?
/*
  提供微信需要的常用函数
*/

 
require_once('weixin.config.php');
require_once(ROOT.'/public/HTTP.php');


function wxGetToken(){
   if($GLOBALS['weixin_token'] ) return $GLOBALS['weixin_token'] ;

  $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential'
            .'&appid='.$GLOBALS['wechat_appid'] .'&secret='.$GLOBALS['wechat_appsecret'];

 $buf = http($url );
 // $buf = file_get_contents($url );
  //echo  $buf. '<hr>';
  
  $rlt  = json_decode($buf);
  $GLOBALS['weixin_token'] = $rlt->access_token;
  return $GLOBALS['weixin_token'];
  
}

function wxKefuMsg($text ,$openid){
	$token = wxGetToken();
	if(!$token) return;
	$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' .$token;
	/*
	$msg['msgtype'] = 'text';
	$msg['touser'] = $openid;
	$msg['text']['content'] = iconv('utf-8','gbk', $text); 
	$para['ext']['content' ]= json_encode($msg);
	*/
	$para['ext']['content' ]= '{"msgtype": "text",   "touser": "' .$openid.'",   "text": {  "content": "'.$text.'" }}';
	 
	$buf = http($url, $para); 
	if(strpos($buf,'"errmsg": "ok"')){
	   return true;
	}
	
	
}

 
function wxQRcode($ids){
   $token = wxGetToken();
  $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$token;
 
   $ticket = array();

	foreach($ids as $id){
	    $json ='{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$id.'}}}';
	    $para['ext']['content']=$json;
	    $buf= http($url, $para);
	    //echo $buf;
	    $js = json_decode($buf);	
	    //var_dump($js);
	    if($js->ticket)
	    {
	       $ticket[$id] = $js->ticket;
	    }
	}

	return $ticket;
	
}

function wxTicketurl($ticket){
	 return  'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' .$ticket;
}

 
function wxLog($msg){
	$msgX = date('Y-m-d H:i:s', time()) . "\n" . $msg . "\n";
	file_put_contents('wx.log', $msgx, FILE_APPEND);
	return $msg;
	
}

 
?>