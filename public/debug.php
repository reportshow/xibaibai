<?

 set_error_handler('debug_handler');
 
function debugX($msg){
	//ob_start();
	debug_print($msg);
	
	debug_print_backtrace();	
	
	//$buf = ob_get_contents();
	//echo $buf;
	//file_put_contents('debug.log', $buf, FILE_APPEND);
	exit();
}


function debug_print($msg)
{
	
 	echo "<div style='clear:both; border£»1px solid #339933;background:#ddffdd; padding:5px;'>" ;
 	if(is_array($msg))
 	  print_r($msg) ;
 	else
 	  echo $msg;
 	  
 	echo "</div>";
  
}

function debug_assert($msg)
{
	
	
 	 
}

function debug_handler($errno, $message, $errfile, $errline)
{
	$msg = $message   .". (file) $errfile ($errline)";
	 if( strpos( $msg  ,'Undefined index') !== false)
	  return;
	 
  switch ($errno) {
  case E_CORE_ERROR:
  case E_USER_ERROR:
  case E_ERROR:
    {
    	debugX( "\r\nError:". $msg );
    }break;
  default:
    //mylog( $msg );
   break;
  }
}
 