<?
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	
	
	$tmp_file = $_FILES['Filedata']['tmp_name'];
	$target_file = uniqid() . basename($_FILES['Filedata']['name']);
	$upload_dir = "uploads";
	if(move_uploaded_file($tmp_file, $upload_dir."/".$target_file)) {
		$message = "File uploaded successfully.";
	} else {
		$error = $_FILES['Filedata']['error'];
		$message = $upload_errors[$error];
	}
	echo $target_file;
}
?>