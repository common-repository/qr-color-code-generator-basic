<?
if(empty($_GET['filename'])){
	    exit;
}
	 
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary');
header('Content-Disposition: attachment; filename="'.$_GET['filename'].'"');
readfile($_GET['filename']);

?>