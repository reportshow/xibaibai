<?
error_reporting(E_ALL^E_NOTICE);
   define('ROOT', '../');
  require_once(ROOT.'public/weixin/weixin.func.php');
  require_once(ROOT.'public/db.function.php');
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <title><?=$title ?></title>
  <body>
  	<center>
  	<h1>随机测试数据</h1><br>
<?
$rooms = db_read('rooms');

foreach($rooms as $id=> $room){
	 
	 $qrcodeurl = wxTicketurl($room['qrcodeurl']);
	 $site = getSiteinfo($room['siteid']);
	echo   "<span style='font-size:14pt;font-weight:bold'> $id. " .$site['school'] . '/'.$site['building'] .'号楼/'. $room['room'] .'室' ."</span>";
	
	echo "<br><img src='$qrcodeurl'  style='width:100%;max-width:520px'>";
	
	 echo "<hr><br><br>"; 
	
}