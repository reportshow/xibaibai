<?
include('QRcode.php');
// QRcode::png ('http://www.phper.org.cn', 'image.png');	// ����ͼ��
//QRcode::png ('http://www.phper.org.cn');

$word = $_GET['QR'];
QRcode::png ($word);

?>