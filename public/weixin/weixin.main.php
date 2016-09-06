<?php
  
//require_once('weixin.func.php');



error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ALL^E_NOTICE);
date_default_timezone_set('PRC');


if(!defined('ROOT'))
{define ('ROOT', dirname(__FILE__.'/../').'/');
} 
 //require_once(ROOT.'public/debug.php');
 require_once('weixin.func.php');



$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{


    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
   
  
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $myName = $postObj->ToUserName;
                $question = trim($postObj->Content);
                $time = $postObj->CreateTime;
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
							
							//file_put_contents('wxsend.txt', $postStr);
							
							$GLOBALS['weixin_openid'] = $fromUsername ;
							$GLOBALS['weixin_master'] = $myName;
							  
							require_once('weixin.route.php');
							
							if( $postObj->MsgType =='text')
							{
								$Content =  "欢迎使用" .  APPNAME ;;
							}
							else if( $postObj->MsgType =='event')
							{								
								$Content = wechat_events($postObj);
							}
							else if($postObj->MsgType =='image')
							{ 
								  ;
							}
							else if($postObj->MsgType =='location')
							{ ;
								$Content = "更新你的坐标:(".$postObj->Location_X .','. $postObj->Location_Y.')'
								      ."\r\n地理位置: " . $postObj->Label ;
							}
							else //voice
							{
								 
							}						
							
					 
							
                   if(!empty( $Content ))
			        {
              		
                	
                	 
                	 if(substr($Content,0,6)=='[news]'){
                		 $data = $GLOBALS['msg_ext'];
                	    $resultStr = $this->makeXML('news',$data);   
                   }else{
                   	 $msgType = "text";
                	     $contentStr =  $Content;                 
                                                    	
                	     $resultStr = sprintf($textTpl, $GLOBALS['weixin_openid'], $myName, $time, $msgType, $contentStr);                   	
                   }
                   //if(defined('WEIXIN_DEBUG')) return $resultStr;
                   
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }
                
                

        }else {
        	echo "";
        	exit;
        }
    }
		
		public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	//echo $echoStr;
         	//exit;    
         	//OK     
        }
        else
        {//Fail 
        //  	exit;
        }
    }
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token =$GLOBALS["wechat_sitetoken"] ;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	 
	private function makeXML($msgType,$data)
	{
		 $time = time();
		 if($msgType =='text' )
		 {
		   $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
			 $resultStr = sprintf($textTpl, $GLOBALS['weixin_openid'], $GLOBALS['weixin_master'], $time, $data);	
			 
		}else if($msgType =='news' )
		{
			 $count = count($data);
			 $resultStr = "<xml>
								 <ToUserName><![CDATA[".$GLOBALS['weixin_openid']."]]></ToUserName>
								 <FromUserName><![CDATA[".$GLOBALS['weixin_master']."]]></FromUserName>
								 <CreateTime>".$time."</CreateTime>
								 <MsgType><![CDATA[news]]></MsgType>
								 <ArticleCount>".$count."</ArticleCount>
								 <Articles>";
				    foreach($data as $v)
				    {		$resultStr .= " 
								 <item>
								 <Title><![CDATA[" . $v['title'] . "]]></Title> 
								 <Description><![CDATA[" . $v['description']."]]></Description>
								 <PicUrl><![CDATA[" . $v['picurl']."]]></PicUrl>
								 <Url><![CDATA[" . $v['link']."]]></Url>
								 </item>";
								 
						}		 
						$resultStr .="</Articles>
								 <FuncFlag>0</FuncFlag>
								 </xml> 
								";
				 $resultXX ="<xml>
						 <ToUserName><![CDATA[".$GLOBALS['weixin_openid']."]]></ToUserName>
						 <FromUserName><![CDATA[".$GLOBALS['weixin_master']."]]></FromUserName>
						 <CreateTime>".$time."</CreateTime>
						 <MsgType><![CDATA[image]]></MsgType>
						 <PicUrl><![CDATA[" . $data[0]['picurl']."]]></PicUrl>
						 <FuncFlag>0</FuncFlag>
						 </xml>";
						 
				//return $resultXX;
						 
		}	
		
		return 	$resultStr;
							
	}
	
	

        
}

?>