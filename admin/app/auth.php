<?

require_once('../../global.php');
require_once(ROOT.'public/db.function.php');
 
/*
 $func = "do_". $_REQUEST['func'] ;
 
 if(function_exists($func)){
 	$func();
  }
 */

 
 do_auth();
 
 function do_auth(){
 	  $workerid = $_GET['user'];
 	  $pwd = $_GET['pwd'];
 	  
 	   $filter = " id = '$workerid' ";	
       $worker =  db_read('worker',$filter );
       if(count($worker) < 2){
       
        $rlt['msg'] ='用户不存在';
        $rlt['code']= 'USER_NOT_EXISTS';
        $rlt['state'] ='err';
      }else  if($worker['password'] != $pwd){
          $rlt['msg'] ='密码错误';
          $rlt['code']= 'PASSWORD_NOT_MATCH';
          $rlt['state'] ='err';
      }else{
      	  $rlt['msg'] ='LOGIN_OK';
          $rlt['state'] ='ok';
      	   $worker['baiduid']=$_GET['baiduid'];
      	   db_write('worker',$worker);
      }
      
      
      jsonOut($rlt);
      
 }
 
 
 
?>