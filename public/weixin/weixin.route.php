<?php

 
function wechat_events($postObj){
	//file_put_contents("wxget.txt", $postObj->Event);
  $func = 'wc_event_'. $postObj->Event; 
  if(function_exists($func)){
    return $func($postObj, $postObj->EventKey);
  }else{
    return ;
  }
   
}
 
function wc_event_LOCATION($postObj, $EventKey=''){
	$Latitude = $postObj->Latitude;
    $Longitude = $postObj->Longitude;
    
    $msg= "坐标:($Latitude,$Longitude)";
    //file_put_contents('pos.txt',$msg);
}

function wc_event_subscribe($postObj, $EventKey=''){
	  if(!function_exists('wx_wellcomedo')){
	      $err =  wxLog("function 'wx_wellcomedo'  not exists");
	       return $err;
	  }
	  $content = wx_wellcomedo($EventKey);	 
	  return strip_tags($content);
}
function wc_event_SCAN($postObj, $EventKey=''){
	 if(!function_exists('wx_scando')){
	      $err =  wxLog("function 'wx_scando'  not exists");
	       return $err;
	  }
	 $content = wx_scando($EventKey);	 
	 
	 return  ($content);
}
function wc_event_CLICK($postObj,$EventKey=''){
	$func = "wxmenu_" .$EventKey;
     if(!function_exists($func)){
	      $err =  wxLog("function '$func'  not exists");
	       return $err;
	  }
    return $func();
	
}
function wc_event_VIEW($postObj,$EventKey=''){
	$url = $EventKey;
	return "you click:  $url";
}

 


?>