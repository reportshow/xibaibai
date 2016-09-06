<?


require_once(ROOT."/public/db.function.php");

function oauth($openid,$nickname,$logintype)
{
	$filter = " openid='".$openid."'";
	$user = db_read('user',$filter);
	if($user){
		//echo "find you";
		//print_r($user);
	}else{
	  //$user['oauth']  = $logintype;
	  $user['openid']	= $openid;
	  //$user['nickname']  = $nickname;
	  $uid = db_write('user',$user);
	  $user['uid'] = $uid;
	  if($nickname=='mobile'){
	  	  //$user['nickname']  = $uid;
	  	  db_write('user',$user);
	  }
  }
 
 //var_dump($user);
	$_SESSION['user_id'] = $user['uid'];
	$_SESSION['user_name']= $user['nickname'];
	$_SESSION['login_type']= $logintype;
	
}

?>