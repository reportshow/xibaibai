<!DOCTYPE html>
<html>
	<head>		
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<style> *{font-size:10pt}
			h1{font-size:20pt;color:red}
			h2{font-size:20pt;color:green}
			</style> 
	</head>		
	<?
error_reporting(E_ALL^E_NOTICE);
date_default_timezone_set('PRC');
	
require_once('pushlib/push.php');
 
if($_POST['password']!='xibb'){
   if($_POST['address']){
 	 echo "<h1>密码错</h1>";
 	}
}else{
	$_POST['time']=date('Y-m-d H:i',time());
	
    $json = "{'orderid':'13'; 'total':110.5, 'address':'baidu push road,#22', 'tel':'13910136035', 'subject':'pingguo lizi xiangjiao boluo', ".
             " 'paytype':'paid',  'time': '10:17 16/07', " .
    		" 'goods':[" .
    		"{'img':100,'title':'baidu1111','price':5.3, 'num':6}," .
    		"{'img':100,'title':'baidu22222','price':15.3, 'num':1}," .
    		"{'img':100,'title':'baidu333','price':10.3, 'num':2}," .
    		"{'img':100,'title':'baidu4444','price':5.3, 'num':1}," .
    		"{'img':100,'title':'baidu555','price':5.3, 'num':4}," .
    		"{'img':100,'title':'baidu666','price':5.3, 'num':7}" .
    		"]}";
     
     
     $goods=$_POST['goods'];
     unset($_POST['goods']);
     $_POST['goods']=array();
     foreach($goods as $g){
     	$_POST['goods'][]=$g;
     }
     
     $json = json_encode($_POST);
  
   
	  $rlt = pushMessage($json, 0);
	  if(!$rlt){
	     echo "<h1>发送失败！！</h1>";	
	  }else{
	  	 echo "<h2>发送成功！！</h1>";	
	  }
}
	 
	 
if($_POST['password']){	
	 echo "<div style='float:left; width:400px'><pre>";  var_dump($_POST) ; echo "</pre></div>";
}	    
 
?>
<DIV style='margin:0px auto; width:400px'>
<form action=? method=post>
	<input type=hidden name=paytype value='paid'>
<br>地址: <input type=text name=address value='北京大学 15#楼 1205室'>
<br>电话: <input type=text name=tel value='139101360'>
<br>摘要: <input type=text name=subject value='新收件'>
<br>
<input type=checkbox name=isreceived   style='width:20px'>收件后: <hr>
 
总价: <input type=text name=total value=100>
<br>订单号:<input type=text name=orderid value=50>
<br>状态:<select  name=state  ><option value=create>创建</option>
	<option value=copy>取单</option><option value=washing>清洗中</option><option value=clean>干净了</option>
	<option value=back>取回</option><option value=done>送达</option>
</select>
<br><input type=text name=goods[1][title]   value='衬衣' style='width:40px'>: <input type=text name=goods[1][price]   value=1.3 size=4>元 x <input type=text name=goods[1][num]   value=2 size=2>
<br><input type=text name=goods[2][title]   value='裤子' style='width:40px'>: <input type=text name=goods[2][price]   value=1.5 size=4>元 x <input type=text name=goods[2][num]   value=6 size=2>
<br><input type=text name=goods[3][title]   value='裙子' style='width:40px'>: <input type=text name=goods[3][price]   value=1.3 size=4>元 x <input type=text name=goods[3][num]   value=2 size=2>
<br><input type=text name=goods[0][title]   value='绒服' style='width:40px'>: <input type=text name=goods[0][price]   value=5.5 size=4>元 x <input type=text name=goods[0][num]   value=1 size=2>
<br>
 <input type=hidden name=goods[1][img] value='100'>
 <input type=hidden name=goods[2][img] value='100'>
 <input type=hidden name=goods[3][img] value='100'>
 <input type=hidden name=goods[0][img] value='100'>
 
 
<br>密码 <input type=texe name=password value=''>
<input type=submit value='提交'>
</DIV>