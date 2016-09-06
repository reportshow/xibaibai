<?
/*
处理微信菜单 等事件
*/
require_once('public/db.function.php');
require_once('func/myfunctions.php');
require_once('orders.php');

function wxmenu_CONTACT(){
	$content =  "客服电话:13910136035";
	 return strip_tags($content);	
}
function wxmenu_OTHERS(){
	return 'others ...';
}
function wxmenu_ORDER(){
	 loglog('get: make order');
	return act_makeorder();
}

function wx_wellcomedo($roomid='')
{ 
	loglog("get:  wellcome, eventkey: " .$EventKey );
 
	$wellcome = "欢迎使用".APPNAME."\r\n 内测期间立赠10元,。马上下单吧:-)";
 
     
	if($roomid  )
	{   
	   $address = addressByroomid($roomid);
	   
	   //return  $address ."\r\n 欢迎关注";
	   
	   $user = getuser();
	   userUpdate($roomid);
	
	   if(count($user) > 0){
	   	  $wellcome = "老朋友，欢迎再次回来";
	   }else{	      
		 $wellcome = "欢迎使用".APPNAME."\r\n 内测期间 A.首次免单，B.还赠送1元,。立即下单吧:-)";
	   }
   
 } 
 
 
 
	 $GLOBALS['msg_ext'][]=  array(
	      'picurl'=> 'http://ding.scicompound.com/xibaibai/imgs/2.jpg',  
	      'title'=> '欢迎使用'. APPNAME,
	      'description'=> '...',
	      'link'=>'http://ding.scicompound.com/xibaibai/'  );

        $GLOBALS['msg_ext'][]=  array(
	      'picurl'=> 'http://ding.scicompound.com/xibaibai/imgs/11772.jpg',  
	      'title'=> $wellcome . "\r\n".$address ,
	      'description'=> '...',
	      'link'=>'http://ding.scicompound.com/xibaibai/'  );
	      
	      
	 return '[news]';  
 
}


function wx_scando($EventKey){
	//return "scan id:" . $EventKey;
	     return act_makeorder(trim($EventKey));		 
}






function act_makeorder($roomid=''){
	if($roomid){
	   $user = userUpdate($roomid);
    }else{
       $user = getuser();
    }
    
    
	
	if( $user['roomid'] < 1)
	{
		makeOrders($roomid);
		return "暂时无法确定你的位置。\n工作人员会与你电话联系再取件，"
		   . "\n请点<a href='http://ding.scicompound.com/xibaibai/action.php?win=me&sub=profile'>这里</a>设置联系方式"
		   . "\n下次请扫扫宿舍后面的二维码可以直接下单/::)";
	}else if(strlen($user['tel']) < 5)
	{
		return "你还未设置联系方式，\n请点<a href='http://ding.scicompound.com/xibaibai/action.php?win=me&sub=profile'>这里</a>设置";
	}else{
	   $editable = strpos('=='.$user['rooms'] ,',') > 0 ?  true : false;
	   $roomid = $user['roomid'] ;
	   return act_makeOrderbyRoom($roomid, $editable);	
	}
	
}
function act_makeOrderbyRoom($roomid,  $editable=false){
	 
	 $address = addressByroomid($roomid); 
	 
	  loglog('act_makeOrderbyRoom');
	  $orderid = makeOrders($roomid);
	  
	 
	  loglog('new orderid:' . $orderid);
	  $worker = getworkerinfo($site['workerid']);
	  $workertel = $worker['tel'];
	  if( $editable)  $address.="<a href='http://ding.scicompound.com/xibaibai/action.php?win=orders&sub=modify&id=$orderid'>[修改]</a>";
	  
	   
	  $msg = "创建订单:$orderid /:coffee \r\n". $address  ."\n (工作人员:". $workertel.'在30分钟内为你取件)' ;;
	  
	  return $msg;
}

 

 


function loglog($msg){
	
	file_put_contents("logs.txt","$msg \r\n " , FILE_APPEND);
	
}


?>