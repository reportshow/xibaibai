<?
session_start();

 
if($_GET['act']=='logout')
{  
	$_SESSION['admin_id']='';
	unset($_SESSION['admin_id']);
  echo ("<script>location.href='./';</script>");	
}

 if($_SESSION['admin_id']) return;
 
$login = $_POST['login_id'];
if($login) {
	$filter = " login = '$login'";	
	 
	$shop =  db_read('shop',$filter );
	$passwordcfg = $shop['password'];
	 
	if(  ($_POST['login_password'])==$passwordcfg)
	{
		$_SESSION['admin_id']= $login;
		return;
	}else{
		 
		$resultmsg = ('账号或密码错误');
	}
}
$lasturl =  $_SERVER["HTTP_REFERER"] ;

require_once('view/head.inc.htm');
 
?>
 

<style>
	*{font-size:9pt}
	 input {padding:5px 10px;display:inline-block;border:1px solid  #2ce;   width:160px;}  
	 input[type=submit]{background: #2ce;color:#fff;   border-radius: 5px;   width:80px;
	  	}
	.title{background: #2ce;height:20px;padding:5px;color:#fff}
	.box{width:320px;margin:50px auto;height:200px;padding:0px ;border:1px solid  #2ce;  
		   border-bottom-right-radius: 9px;   border-bottom-left-radius: 9px;  
		   box-shadow: 5px 5px 5px #aaa;
		   }
</style>
 
<div style='margin:0px auto;width:300px'><?=$resultmsg ?></div>
<div class=box>
  <div class=title>管理员验证</div>
  
  <div style='margin:10px 30px;padding:13px;'>
	<form action='?' method=post >
		 用户：&nbsp;<input type=text name=login_id  value='<?=$login ?>' ><p>
		 密码：&nbsp;<input type=password name=login_password><p>
		 <span style='visibility:hidden'>登陆:</span>
		   <input type=submit value=' 确  定 '>
	</form>
  </div>
</div>
</body></html>
<?

exit;

?>