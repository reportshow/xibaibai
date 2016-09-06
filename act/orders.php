<?
 
require_once(ROOT.'public/weixin/weixin.func.php');
require_once(ROOT.'func/room.site.php');

function do_changeaddr(){
	//file_put_contents('tt.x',"do_changeaddr");
	$orderid = $_GET['id'];
	$newroomid = $_GET['newroomid'];
	
	$order = db_read('orders', $orderid);		 
	$order['roomid']=$newroomid;

	if($newroomid=='-1')
	{   
		$siteid = $_GET['siteid'];
		$site = getSiteinfo($siteid);
		
		$order['comment'] = $site['school'] . '/'.$site['building'] . '/'. $_GET['room'];
		$txt = "订单地址修改为:\n" . $site['school'] . '/'. $site['building'] . '号楼/'. $_GET['room'].'室';
		$order['workerid'] = $site['workerid'];
	}else{
		
	   $order['workerid'] = getworkerid($newroomid);
	}
	
	db_write('orders', $order);
	 
	if(!$txt ) $txt = "订单地址修改为:\n" .  addressByroomid($newroomid);
	 
	wxKefuMsg($txt, $_SESSION['openid']);
	echo "orderid: $orderid,  newaddrid:$newroomid";
}

 

function do_copy(){
	
	 $json = $_POST['POST'];
	 $post = json_decode($json);
	 $post =object_to_array($post) ;
	 
	 if(!$post['goods'] || !$post['orderid']){	 	
	    $msg['state']='err';
	 	$msg['code']='NO_GOODS_INFO';
	 	 
	 	 jsonOut($msg);
	 	return;
	}
	 
	
	 $orderid = $post['orderid'];	 
	 //TODO
	 $order = db_read('orders', $orderid);	
	 if(count($order) < 2){
	     $msg['state']='err';
	 	$msg['code']='NO_ORDER';
	 	 jsonOut($msg);
	 	return;
	 }
	 
	 $worker = getworkerinfo($order['workerid']);
	 /*
	 if($worker['baiduid']!= $post['workerbaiduid']){
	 	$msg['state']='err';
	 	$msg['code']='PERMISSION_DENIED';
	 	 jsonOut($msg);
	 	return;
	 }
	 */
	//计算一下paid是否正确
	  
	$order['paid'] =  $post['paid'];
	$order['goods'] = json_encode( $post['goods']);
	$order['state'] =  'copy';
	db_write('orders',$order);
	
	$msg['state']='ok'; 
	jsonOut($msg);
	return;
	
}

function do_done(){
	$json = $_POST['POST'];
	 $post = json_decode($json);
	 $post =object_to_array($post) ;
	 
	 if( !$post['orderid']){	 	
	    $msg['state']='err';
	 	$msg['code']='NO_GOODS_INFO';
	 	 
	 	 jsonOut($msg);
	 	return;
	}
	 	
	 $orderid = $post['orderid'];	 
	 $order = db_read('orders', $orderid);	
	 $order['state'] =  'done';
	 db_write('orders',$order);
}


function do_remove(){
	$oid = $_GET['id'];
	$order = db_read('orders',$oid);
	
	 
	var_dump(  $order['userid']);
	if($order['userid']==$_SESSION['user_id']){
	  db_delete_one('orders',$oid);
	  echo "--[OK]";
    }
    
	
}


function checkAppInfo(){
	
}


function  makeOrders($roomid=''){
	$openid =$GLOBALS['weixin_openid'];
	$ord['roomid'] = $roomid;
	if($_SESSION['user_id']) {
	   $ord['userid'] = $_SESSION['user_id'];
    }else{
       $user = getuser();
       $ord['userid'] = $user['uid'];
    }
    if(!$ord['userid']){
    	    $user['openid'] =$GLOBALS['weixin_openid']; ;
    	    $user['roomid'] = $roomid;
    	    $uid = db_write('user',$user);
    	    $ord['userid'] = $uid;
    }
     loglog('makeOrders');
    $ord['create_time'] = time();
    $ord['state'] = 'create';
    $ord['workerid'] = getworkerid($roomid);
    $uid =  db_write('orders', $ord);    
    
    mail2worker();
    return $uid;
	
}


function mail2worker(){
	  
	$url = "http://" . $_SERVER["SERVER_NAME"] .'/xibaibai/act.php?target=pushupdate&func=create';
	//loglog("touch $url");
	http_touch($url);
}

 