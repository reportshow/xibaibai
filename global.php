<?php

error_reporting(E_ALL^E_NOTICE);
date_default_timezone_set('PRC');

session_start();

define ('ROOT', dirname(__FILE__).'/'); 





require_once('global.config.php');

require_once(ROOT.'public/debug.php');
require_once(ROOT.'public/functions.php');
require_once(ROOT.'public/db.function.php');
require_once(ROOT.'public/config.cache.php');
require_once(ROOT.'public/mobile.php');


require_once(ROOT.'func/myfunctions.php');

require_once(ROOT.'public/global.route.php');





//auto include;
/*
$myfuncfiles = scandir(ROOT.'func/');
foreach($myfuncfiles as $funcfile){	 
	if(substr($funcfile,0,1)=='.') continue;
	require_once(ROOT.'func/'.$funcfile);
}
*/


