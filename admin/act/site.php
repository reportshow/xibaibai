<?


function do_saveworker(){
	$siteid = $_GET['siteid'];
	$workerloginid = $_GET['workerloginid'];
	
	$filter = " id = '$workerloginid' ";	
     $worker =  db_read('worker',$filter );
     if(count($worker) < 2){
         $rlt['state'] ='ID_NOT_EXIST'; 	
         $rlt['msgtext'] ='ID不存在'; 	
         jsonOut($rlt); return;
     }
	
	$workerid = $worker['uid'];
	
	$site = db_read('site', $siteid);
	if(count($site) > 1){
	  $site['workerid'] = $workerid;
	  db_write('site',$site);
	     $rlt['state'] ='ok'; 	
         $rlt['msgtext'] ='操作完成'; 	
         jsonOut($rlt);
	}
	
}