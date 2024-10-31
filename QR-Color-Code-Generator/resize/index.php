<?php

	// *** Include the class
	include("resize-class.php");

	// *** 1) Initialise / load image
	$resizeObj = new resize('sample.jpg');

	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(150, 25);

	// *** 3) Save image
	$resizeObj -> saveImage('sample-resized.jpg', 100);
	//header('Content-Type: image/png');
	//imagepng($resizeObj);
	echo ini_get('max_execution_time');



?>
