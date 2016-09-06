<?

 if (get_magic_quotes_gpc()) {
	function stripslashes_deep($value){
		$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value); 
		return $value; 
	}
	$_POST = array_map('stripslashes_deep', $_POST);
	$_GET = array_map('stripslashes_deep', $_GET);
	$_COOKIE = array_map('stripslashes_deep', $_COOKIE); 
}

function jsonOut($msg){
	//var_dump( $msg);
	$msg['tag'] ='HAVE_RETURN';
	echo json_encode($msg);
}


function object_to_array($obj){
$_arr = is_object($obj)? get_object_vars($obj) :$obj;
foreach ($_arr as $key => $val){
$val=(is_array($val)) || is_object($val) ? object_to_array($val) :$val;
$arr[$key] = $val;
}
return $arr;
     
}