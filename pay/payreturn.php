<?
 require_once('global.php');
 require_once('func/functions.php');
 require_once('func/dbfunction.php');

 $return = var_export($_REQUEST,1);
 file_put_contents($return,'pay.txt');
 
 
?>