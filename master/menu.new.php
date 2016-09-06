<?
error_reporting(E_ALL^E_NOTICE);
  define ('ROOT', dirname('../global.php').'/'); 
  //require_once('../func/weixin.config.php');
  require_once(ROOT.'public/weixin/weixin.func.php');
   

 

  if($_GET['token'] != 'afjwljeioioo33')
  exit('Token fail.');
  

  
  $json = '{
     "button":[     
       {  
               "type":"click",
               "name":"下单",
              "key":"ORDER"           
          
       },        
      {
           "name":"我的..",
           "sub_button":[
	           {	
	               "type":"view",
	               "name":"当前订单",
	               "url":"http://ding.scicompound.com/xibaibai/action.php?win=orders&sub=current"
	            },
	            {
	               "type":"view",
	               "name":"历史订单",
	               "url":"http://ding.scicompound.com/xibaibai/action.php?win=orders&sub=history"
	            },
	            {
	               "type":"view",
	               "name":"我的账户",
	               "url":"http://ding.scicompound.com/xibaibai/action.php?win=me&sub=profile"
	            },
	            {
	               "type":"view",
	               "name":"手机绑定/解绑",
	               "url":"http://ding.scicompound.com/xibaibai/action.php?win=me&sub=profile"
	            }
            ]
       },
      {
           "name":"关于校园宝",
           "sub_button":[
            {	
               "type":"view",
               "name":"价格列表",
               "url":"http://ding.scicompound.com/xibaibai/action.php?win=about&sub=price"
            },
           {	
               "type":"view",
               "name":"服务承诺",
               "url":"http://ding.scicompound.com/xibaibai/action.php?win=about&sub=promise"
            },
            {
               "type":"click",
               "name":"联系方式",
               "key":"CONTACT"
            }]
       }
       
       
  ] }';
 
  $token = wxGetToken();
  echo $token;
  $url  ='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='. $token;;
  $para['ext']['content'] = $json;
  
   $buf = http($url,$para);
  
   print_r($buf);

?>