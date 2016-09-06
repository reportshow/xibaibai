<?

if($_GET['from']=='app'){
	$post = $_POST['POST'];
	
}

 
function getuser(){
	 $openid = useropenid();
	 
	 if(!$openid) exit('permission denied');
	 $filter = "openid='$openid'";;
   
	 $user = db_read('user',$filter);
	 if(count($user) > 1){
	 	$_SESSION['user_id'] = $user['uid'];
	 }
	 return $user;
}
 
function useropenid(){
	 $openid =$_SESSION['openid'];
	 if(!$openid)  {
	 	 $openid =$GLOBALS['weixin_openid'] ;	 
	     $_SESSION['openid'] =$GLOBALS['weixin_openid'] ;
	 }
	 return $openid;
}

function userUpdate($roomid){	
	 if(!$roomid) return;
	$openid = useropenid();
	 $user = getuser();
	 if(count($user)  < 1){
	    $user['openid'] = $openid ;
	 }
	 $user['roomid'] = $roomid ;
	 $rooms = $user['rooms'];
	 $nearbys = explode(',', $rooms);
	 if(! in_array($roomid, $nearbys )){
	 	$nearbys[]=$roomid ;
	 }
	 $user['rooms'] = implode(',', $nearbys);
	 db_write('user',$user);
	 return $user;
}