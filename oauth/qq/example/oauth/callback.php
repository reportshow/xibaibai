<?php
require_once("../../API/qqConnectAPI.php");
$qc = new QC();
echo $qc->qq_callback();
echo $qc->get_openid();


echo "<pre><br>";
print_r($_SERVER);