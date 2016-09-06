<?php

/**********************
cache 2014.8
config 2014.8

$GLOBALS['db_cache_path'];
$GLOBALS['config_path'];
********************/
 



//读文件
function cache_read($file)
{  
	$file =  cache_filepath($file);
	//echo $file . '===';
	if(file_exists($file))
	{  include($file);	 
	   return $content;
	}
}
 
//写缓存内容
function cache_write($file,$content)
{
	$file = cache_filepath($file);
	if(is_array($content))
	{
		$content= var_export($content,1);
	}
	else
	{
		$content='array()';
	}	 
	/*$content = '<?  $content = unserialize (\'' . serialize($content) . '\');  ?>';	  */
	$content = '<?  $content =    ' .  ($content) . '  ;  ?>';	 
	
	 
	 file_put_contents($file,$content);
 
	 
}
function cache_filepath($file)
{  
	$folder=$GLOBALS['db_cache_path'];
   if($folder && substr($folder,0,1)!=DIRECTORY_SEPARATOR)
	{
		$folder .=DIRECTORY_SEPARATOR;
	}
	return  $folder.'cache.'.($file) .'.php';
}
function cache_outofdate($file, $long){
  $file = cache_filepath($file);
  if(!is_file($file))  return true;
  
  $t = filemtime ($file);
  if(time()-$t > $long)  return true;
  else return false;
  
}





function config_filepath()
{  
	$folder=$GLOBALS['config_path'];
	if($folder && substr($folder,0,1)!=DIRECTORY_SEPARATOR)
	{
		$folder .=DIRECTORY_SEPARATOR;
	}
	return  $folder.'__config.php';
}
function config_read($sub, $key,$val=null){
	$file = config_filepath();
	 if(file_exists($file))
	{  include($file);	 
	   $valo = $content[$sub][$key];
	   if($valo==null) $valo = $val;
	   return $valo;
	}
	 
}
function config_write($sub, $key, $val){
	$file = config_filepath();
	if(file_exists($file))
	{  include($file);	 	    
	} 
	
	$content[$sub][$key] = $val;;
	
	$content= var_export($content,1);
	$content = '<?  $content =    ' .  ($content) . '  ;  ?>';	 
	file_put_contents($file,$content);
}


if(!function_exists('file_put_contents'))
{
	 function file_put_contents($file, $content){
		$fp=fopen($file,'w');
		  flock($fp,2);  //加锁
		fwrite($fp,$content);
			if(flock($fp,3))    //解除锁定
		fclose($fp);
		
	}
}