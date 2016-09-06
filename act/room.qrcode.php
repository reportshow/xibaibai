<?
error_reporting(E_ALL^E_NOTICE);
 
  require_once(ROOT.'public/weixin/weixin.func.php');
  require_once(ROOT.'func/room.site.php');
 
  $room = db_read('rooms', $_GET['ids']);
  $imgurl = getQRlink($room); 
  
  echo $imgurl;