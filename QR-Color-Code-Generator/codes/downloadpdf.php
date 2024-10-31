<?
require '../fpdf/fpdf.php';
if(empty($_GET['filename'])){
	    exit;
}
list($width, $height, $type, $attr) = getimagesize($_GET['filename']);
$pdf = new FPDF('P', 'pt', array($width,$height));

$pdf->addPage();


$pdf->Image($_GET['filename'], 0, 0, $width, $height, 'PNG');

$pdf->Output(trim($_GET['filename'], ".png") . '.pdf','I');

?>