<?php
   
  error_reporting(E_ALL^E_NOTICE);
  define ('ROOT', dirname('../global.php').'/'); 
  //require_once('../func/weixin.config.php');
  require_once(ROOT.'public/weixin/weixin.func.php');
   

 

  if($_GET['token'] != 'afjwljeioioo33' && $argv[1]!='afjwljeioioo33')
  exit('Token fail.');
  

  
  $json = '{ "button": [ 
       {
           "name":"我的报告",
           "sub_button":[
	           {	
	               "type":"view",
	               "name":"查看报告",
	               "url":"http://ding.scicompound.com/xibaibai/action.php?win=orders&sub=current"
	            },
	            {
	               "type":"view",
	               "name":"上传图片",
	               "url":"http://ding.scicompound.com/xibaibai/action.php?win=orders&sub=history"
	            },
              {
                 "type":"view",
                 "name":"我的图片",
                 "url":"http://ding.scicompound.com/xibaibai/action.php?win=orders&sub=history"
              } 
	             
            ]
       },

        {
           "name":"记事本",
           "sub_button":[
            { 
               "type":"view",
               "name":"新建记事",
               "url":"http://ding.scicompound.com/xibaibai/action.php?win=about&sub=price"
            },
           {  
               "type":"view",
               "name":"查看记事",
               "url":"http://ding.scicompound.com/xibaibai/action.php?win=about&sub=promise"
            } 
            ]
       },

      {
           "name":"检测流程",
           "sub_button":[
            {	
               "type":"view",
               "name":"检测流程",
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