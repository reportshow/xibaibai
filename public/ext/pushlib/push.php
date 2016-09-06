<?php

 
require_once ( "push.class.php" ) ;
 
require_once ( "push.config.php" ) ;
 

    		
 
    		

 
 /*  pushMessage($Json);
 *   userid:  0 表示全部   , 字符串 表示tag   
 *   msg:  透传随意格式，  提醒消息按固定格式(设置type='notify')
 *   type: msg 透传  notify 提醒
 **/
 function pushMessage ($message, $user_id=0,  $type='msg')
{
    global $baiduApiKey;
	global $baiduSecretKey;
    $channel = new Channel ( $baiduApiKey, $baiduSecretKey ) ;
    //http://developer.baidu.com/wiki/index.php?title=docs/cplat/push/sdk/phpserver#pushMessage
	//推送消息到某个user，设置push_type = 1; 
	//推送消息到一个tag中的全部user，设置push_type = 2;
	//推送消息到该app中的全部user，设置push_type = 3;
	
	$push_type = 1; //推送单播消息
	
	 if(is_string($user_id) )//按tag推送
	{   $tags =  $user_id;
		$push_type = 2; 
	    $optional[Channel::TAG_NAME] = $tags;  //如果推送tag消息，需要指定tag_name	
	    	
	}else if($user_id == 0 )//全部user
	{   
		$push_type = 3; 
	}	else	if($user_id  > 10 )
	{
		$push_type = 1; //推送单播消息
		$optional[Channel::USER_ID] = $user_id; //如果推送单播消息，需要指定user
	}
	 
	
//指定消息类型为通知 0 透传,  1notify
   if($type =='msg')
   {
   	  $optional[Channel::MESSAGE_TYPE] = 0;
   	}else{
	  $optional[Channel::MESSAGE_TYPE] = 1;
   }
	//指定发到android设备
	$optional[Channel::DEVICE_TYPE] = 3;
	
	//通知类型的内容必须按指定内容发送，示例如下：
	/* $message = '{ 
			"title": "test_push",
			"description": "open url",
			"notification_basic_style":7,
			"open_type":1,
			"url":"http://www.baidu.com"
 		}';
 	*/
 	//透传消息 随便格式
 		
 
	$message_key = "msg_id".time() . rand(); //用不同id
    $ret = $channel->pushMessage ( $push_type, $message, $message_key, $optional ) ;
    if ( false === $ret )
    {
       /* echo  ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
        echo ( 'ERROR NUMBER: ' . $channel->errno ( ) ) ;
        echo ( 'ERROR MESSAGE: ' . $channel->errmsg ( ) ) ;
        echo ( 'REQUEST ID: ' . $channel->getRequestId ( ) );
        */
    }
    else
    {
       /* echo ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
        echo ( 'result: ' . print_r ( $ret, true ) ) ;*/
    }
    
    return $ret;
}


