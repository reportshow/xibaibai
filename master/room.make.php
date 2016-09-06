<?
error_reporting(E_ALL^E_NOTICE);
   define('ROOT', '../');
  require_once(ROOT.'public/weixin/weixin.func.php');
  require_once(ROOT.'public/db.function.php');
    
$ids=array(101,102,103,104,105);
$tickets = wxQRcode($ids);
 

foreach($tickets as $id=> $tkt){
	$room = db_read_one('rooms', $id);
	//var_dump($room);
	$room['uid']=($id).'';
	$room['qrcodeurl'] = $tkt;
	
	db_write('rooms', $room);
	
}