<?
include('QRcode.php');
// QRcode::png ('http://www.phper.org.cn', 'image.png');	// µ¼³öÍ¼Ïñ
//QRcode::png ('http://www.phper.org.cn');

$word = $_GET['QR'];
QRcode::png ($word);

?>