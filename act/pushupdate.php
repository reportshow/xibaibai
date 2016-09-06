<?php
	
  
 require_once(ROOT.'public/ext/pushlib/push.php');
 require_once(ROOT.'func/room.site.php');
ignore_user_abort(true);  

	   
function do_create(){
 
   //require_once(ROOT.'func/db.keytxt.php'); 
   //$state = $ORDER_STATE[$order['state']] ;
 
  $filter = " state='create'  ";
  $filterX = "(".$filter.") AND  (stateworker='' OR stateworker is NULL)";
  $orders = db_read_array('orders', array(), $filterX);
  
  if(count($orders) < 1){
  	
     echo "<br>no orders";
  }
 
  foreach($orders as $oid => $order){
  	 $ord['orderid'] = $oid;
  	 $ord['address']= addressByroomid($order['roomid']);
  	 $user = db_read('user', $order['userid']); 
  	 $ord['tel']= $user['tel'];
  	 $ord['name']= $user['name'];
  	 $ord['subject'] ='new order';
  	 $ord['paytype'] ='f2f';
  	 $ord['time'] = date('Y-m-d H:i',$order['create_time']);
  	 $ord['goods'] = array();
  	 $ord['total'] = 1; //remove
  	 $ord['state'] = $order['state']; 
  	 $json = json_encode($ord);
  	 $userTag = 0;
  	         $rlt =  rerePush($json, $userTag);  	          
		      
		     if($rlt){
		     	 //标记已经发送notify
		     	 $order['stateworker']= 'copy_notified';
  	              db_write('orders',$order); 		     	 
		     }
		     
		      if($rlt) echo $ord['address'] ."== push ";
		      else    echo  $ord['address'] ."==fail";
  	 
  }
 	  	 	 
/* 
    $json = "{'total':110.5, 'address':'baidu push road,#22', 'tel':'13910136035', 'subject':'pingguo lizi xiangjiao boluo', ".
             " 'paytype':'paid',  'time': '10:17 16/07', " .
    		" 'goods':[" .
    		"{'img':100,'title':'baidu1111','price':5.3, 'num':6}," .
    		"{'img':100,'title':'baidu22222','price':15.3, 'num':1}," .
    		"{'img':100,'title':'baidu333','price':10.3, 'num':2}," .
    		"{'img':100,'title':'baidu4444','price':5.3, 'num':1}," .
    		"{'img':100,'title':'baidu555','price':5.3, 'num':4}," .
    		"{'img':100,'title':'baidu666','price':5.3, 'num':7}" .
    		"]}";
  
	   $rlt = pushMessage($json, 0);
	  var_dump($rlt);	        
*/
 }
 
 
 
 function do_pushstate(){
 	
 	$order = db_read('orders', $_GET['orderid']);
 	if(count($order) < 1) 
 	{  echo "order not exist";
 		return;
    }  
 	 $userTag = 0;
 	 $cmd['state'] = $_GET['state'];
 	 $cmd['orderid'] = $_GET['orderid'];
 	 $cmd['command'] = 'changestate';
  	 $json = json_encode($cmd);
     $rlt =  rerePush($json, $userTag);
	  
	 $order = db_read('orders', $_GET['orderid']);
	 
 	 if($rlt){		  
		  $order['state'] = $_GET['state'];
		  $order['stateworker']= $_GET['state']. '_notified';
  	      db_write('orders',$order); 		     	 
     }
     
     $msg = "orderid=".$order['uid'] .",state=" . $_GET['state'];
     if($rlt) echo $msg ."== push ";
	 else    echo  $msg ."==fail";
     
 }
 
 function multi_pushstate($jsonM){
 	 $userTag =0;
 	
 	$json['commandjson'] = $jsonM;
 	$json['command'] = 'multi_changestate';
 	$json = json_encode($json);
 	$rlt =  rerePush($json, $userTag);
 	

	 
 	 if($rlt){	
 	 	foreach($jsonM as $cmd){ 
 	       $order = db_read('orders', $cmd['orderid']);
		  $order['state'] = $cmd['state'];
		  $order['stateworker']= $cmd['state']. '_notified';
  	      db_write('orders',$order); 		
  	    } 
  	    
  	    
     }
     
     return $rlt;
     
 }
 
 //act.php?target=pushupdate&func=pushnewprice
  function do_pushnewprice(){
  	  require_once(ROOT."func/db.keytxt.php");
  	  $YIFU_Price= array();
  	  foreach($YIFU_TYPES as $yifu){
  	  	  if($yifu['price'] < 0.01){
  	  	    continue;   
  	  	  }
  	  	 $YIFU_Price[]=$yifu;
  	  }
  	  
  	  $yifu = json_encode($YIFU_Price);
  	  $userTag = 0;
  	  
  	 $json['yifujson'] = $yifu; //字符串
 	 $json['command'] = 'changeprice';
 	 $json = json_encode($json);
 	 $rlt =  rerePush($json, $userTag);
 	 
 	 if($rlt){	
 	    echo "new price push done";
     }else{
     	echo " push fail ";
     }
     
     return $rlt;
  	
  }
 function rerePush($json, $userTag){
          for($i=0; $i< 8; $i++)
	     {
	        $rlt = pushMessage($json, $userTag);
	        if($rlt) break;
	        sleep(1);
	     }
	     return $rlt;
		      
 }