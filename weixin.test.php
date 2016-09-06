<?
define('WEIXIN_DEBUG',1);
$wx['type']='event';
$wx['event']='SCAN';
$wx['eventkey']='2';

$wx['type']='event';
$wx['event']='click';
$wx['eventkey']='ORDER';

 $GLOBALS["HTTP_RAW_POST_DATA"] = makeRequest($wx);
 
 
$resultStr = require_once('wx_xibaibai.php');
 
 //echo iconv('utf-8','gbk',$resultStr);
 function makeRequest($wx){
 	
 $time = time();
 $fromUser = 'weixin_test_openid';
 
  $type = $wx['type'];
 if($type =='text'){
 	 $content =  $wx['content'];;
 $REQ = "<xml>
 <ToUserName><![CDATA[toUser]]></ToUserName>
 <FromUserName><![CDATA[$fromUser]]></FromUserName> 
 <CreateTime>$time</CreateTime>
 <MsgType><![CDATA[$type]]></MsgType>
 <Content><![CDATA[$content]]></Content>
 <MsgId>1234567890123456</MsgId>
 </xml>";
}else  if($type =='event'){

 $event =  $wx['event'];
 $EventKey =   $wx['eventkey'];
  $REQ = "<xml><ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[$fromUser]]></FromUserName>
<CreateTime>$time</CreateTime>
<MsgType><![CDATA[$type]]></MsgType>
<Event><![CDATA[$event]]></Event>
<EventKey><![CDATA[$EventKey]]></EventKey>
<Ticket><![CDATA[TICKET]]></Ticket>
</xml>";
}
 	return $REQ;
}