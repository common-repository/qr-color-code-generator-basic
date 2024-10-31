<?
include_once('../../../../wp-config.php');
include_once('../../../../wp-load.php');
include_once('../../../../wp-includes/wp-db.php');
global $wpdb; 

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
 
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb; 
}

    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'codes'.DIRECTORY_SEPARATOR;
    
    $PNG_WEB_DIR = 'codes/';

    $QR_BASEDIR = dirname(__FILE__).DIRECTORY_SEPARATOR;
	
	include "phpqrcode/qrconst.php";
	include "phpqrcode/qrconfig.php";
	include "phpqrcode/qrtools.php";
	include "phpqrcode/qrspec.php";
	define('QR_IMAGE', true);

    class QRimage {
    
        //----------------------------------------------------------------------
        public static function png($frame, $filename = false, $pixelPerPoint = 4, $outerFrame = 4,$saveandprint=FALSE) 
        {
            $image = self::image($frame, $pixelPerPoint, $outerFrame);
            
            if ($filename === false) {
                Header("Content-type: image/png");
                ImagePng($image);
            } else {
                if($saveandprint===TRUE){
                    ImagePng($image, $filename);
                    header("Content-type: image/png");
                    ImagePng($image);
                }else{
                    ImagePng($image, $filename);
                }
            }
            
            ImageDestroy($image);
        }
    
        //----------------------------------------------------------------------
        public static function jpg($frame, $filename = false, $pixelPerPoint = 8, $outerFrame = 4, $q = 85) 
        {
            $image = self::image($frame, $pixelPerPoint, $outerFrame);
            
            if ($filename === false) {
                Header("Content-type: image/jpeg");
                ImageJpeg($image, null, $q);
            } else {
                ImageJpeg($image, $filename, $q);            
            }
            
            ImageDestroy($image);
        }
    
        //----------------------------------------------------------------------
        private static function image($frame, $pixelPerPoint = 4, $outerFrame = 4) 
        {
            $h = count($frame);
            $w = strlen($frame[0]);
            
            $imgW = $w + 2*$outerFrame;
            $imgH = $h + 2*$outerFrame;
            
            $base_image =ImageCreate($imgW, $imgH);
	
			if (isset($_REQUEST['background']) && $_REQUEST['background'] == "solid")
			{ 
				
				$startbg = ltrim($_REQUEST['backgroundsolidbox'], "#");
				$endbg = ltrim($_REQUEST['backgroundsolidbox'], "#");
	
				
			}
			else
			{
				
				$startbg = ltrim($_REQUEST['backgroundstart'], "#");
				$endbg = ltrim($_REQUEST['backgroundend'], "#");
	
				
			}
             
			$start_r = hexdec(substr($startbg, 0, 2));
			$start_g = hexdec(substr($startbg, 2, 2));
			$start_b = hexdec(substr($startbg, 4, 2));
			$end_r = hexdec(substr($endbg, 0, 2));
			$end_g = hexdec(substr($endbg, 2, 2));
			$end_b = hexdec(substr($endbg, 4, 2));

			
			for($y=0; $y<$h; $y++) {
                for($x=0; $x<$w; $x++) {
                    if ($frame[$y][$x] == '1') {
						 if ($start_r == $end_r) {
     					$new_r = $start_r;
   					 }
   					 $difference = $start_r - $end_r;
   					 $new_r = $start_r - intval(($difference / $h) * $y); 
    				if ($start_g == $end_g) {
     					$new_g = $start_g;
   					 }
    				$difference = $start_g - $end_g;
   					 $new_g = $start_g - intval(($difference / $h) * $y);         
   					 if ($start_b == $end_b) {
     					 $new_b = $start_b;
   					 }
   					 $difference = $start_b - $end_b;
   					 $new_b = $start_b - intval(($difference / $h) * $y);
    				 $row_color = imagecolorresolve($base_image, $new_r, $new_g, $new_b);
                       ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$row_color); 
                    }
                }
            }
			
			
			if (isset($_REQUEST['foreground']) && $_REQUEST['foreground'] == "solid")
			{  
				$startfg = ltrim($_REQUEST['foregroundsolidbox'], "#");
				$endfg = ltrim($_REQUEST['foregroundsolidbox'], "#");;
	
					
			}
			else
			{
				
				$startfg = ltrim($_REQUEST['foregroundstart'], "#");
				$endfg = ltrim($_REQUEST['foregroundend'], "#");
		
			}
			
			$start_rfg = hexdec(substr($startfg, 0, 2));
			$start_gfg = hexdec(substr($startfg, 2, 2));
			$start_bfg = hexdec(substr($startfg, 4, 2));
			$end_rfg = hexdec(substr($endfg, 0, 2));
			$end_gfg = hexdec(substr($endfg, 2, 2));
			$end_bfg = hexdec(substr($endfg, 4, 2));
		
			for($y=0; $y<$h; $y++) {
                for($x=0; $x<$w; $x++) {
                    if ($frame[$y][$x] == '1') {
						 if ($start_rfg == $end_rfg) {
     					$new_rfg = $start_rfg;
   					 }
   					 $difference = $start_rfg - $end_rfg;
   					 $new_rfg = $start_rfg - intval(($difference / $h) * $y); 
    				if ($start_gfg == $end_gfg) {
     					$new_gfg = $start_gfg;
   					 }
    				$difference = $start_gfg - $end_gfg;
   					 $new_gfg = $start_gfg - intval(($difference / $h) * $y);         
   					 if ($start_bfg == $end_bfg) {
     					 $new_bfg = $start_bfg;
   					 }
   					 $difference = $start_bfg - $end_bfg;
   					 $new_bfg = $start_bfg - intval(($difference / $h) * $y);
    				 $row_color = imagecolorresolve($base_image, $new_rfg, $new_gfg, $new_bfg);
					 
					   ImageSetPixel($base_image,$x+$outerFrame,$y+$outerFrame,$row_color); 
                    }
                }
            }
            
            $target_image =ImageCreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
            ImageCopyResized($target_image, $base_image, 0, 0, 0, 0, $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH);
			
	
            ImageDestroy($base_image);
			
			
            
            return $target_image;
		} ///////////END OF URL REQUEST
        }

	include "phpqrcode/qrinput.php";
	include "phpqrcode/qrbitstream.php";
	include "phpqrcode/qrsplit.php";
	include "phpqrcode/qrrscode.php";
	include "phpqrcode/qrmask.php";
	include "phpqrcode/qrencode.php"; 
	 




 
		if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);

    $errorCorrectionLevel = $_REQUEST['correction'];
        

    $matrixPointSize = $_REQUEST['size'];
        
        /////////////// URL    
		if(isset($_REQUEST['type']) && $_REQUEST['type'] == "url")
		{
        	$filename = $PNG_TEMP_DIR.'code'. uniqid() . md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
				 
		}
		
		
		
		/////////////// email    
		if(isset($_REQUEST['type']) && $_REQUEST['type'] == "email")
		{
			$emailstring = 'mailto:' . $_REQUEST['emailaddress'] . "?subject=" . $_REQUEST['subject'] . "&body=" . $_REQUEST['body'];

        	$filename = $PNG_TEMP_DIR.'code'. uniqid() . md5($emailstring.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			
       	    	QRcode::png($emailstring, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
				 
		}
		
		/////////////// sms    
		if(isset($_REQUEST['type']) && $_REQUEST['type'] == "sms")
		{
			$smsstring = "sms:" . $_REQUEST['smsnumber'] . ":" . $_REQUEST['smsbody'];
        	$filename = $PNG_TEMP_DIR.'code'. uniqid() . md5($smsstring.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			
       	    	QRcode::png($smsstring, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
				 
		}
		
		/////////////// phonecall    
		if(isset($_REQUEST['type']) && $_REQUEST['type'] == "phonecall")
		{
        	$filename = $PNG_TEMP_DIR.'code'. uniqid() . md5('tel:' . $_REQUEST['phone'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			
       	    	QRcode::png('tel:' . $_REQUEST['phone'], $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
				 
		}
		
		
		
		/////////////// wifi    
		if(isset($_REQUEST['type']) && $_REQUEST['type'] == "wifi")
		{
			$wifistring = "WIFI:S:" . $_REQUEST['ssid'] . ";T:" . $_REQUEST['encryption'] . ";P:" . $_REQUEST['password'] . ";;";
        	$filename = $PNG_TEMP_DIR.'code'. uniqid() . md5($wifistring.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
			
       	    	QRcode::png($wifistring, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
				 
		}
		
		/////////////// bookmark    
		if(isset($_REQUEST['type']) && $_REQUEST['type'] == "bookmark")
		{
			$bookmarkstring = "MEBKM:TITLE:" . $_REQUEST['bookmarktitle'] . ";URL:" . $_REQUEST['bookmarkurl'];

        	$filename = $PNG_TEMP_DIR.'code'. uniqid() . md5($bookmarkstring.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		
       	    	QRcode::png($bookmarkstring, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
				 
		}
		

		

				echo basename($filename);  
				include_once('../../../../wp-config.php');
				include_once('../../../../wp-load.php');
				include_once('../../../../wp-includes/wp-db.php');
				global $wpdb; 
				$table_name = $wpdb->prefix . "qrcolorcodes";
				if(isset($_REQUEST['QRname']))
				{
					$qrcode_name = $_REQUEST['QRname'];
					$qrcode_url = basename($filename);
					$qrcode_type = $_REQUEST['type'];
					$wpdb->insert($table_name, array('qrcode_name' => $qrcode_name, 'qrcode_url' => $qrcode_url, 'qrcode_type' => $qrcode_type));
				} 
		
			
			
			
	
    
?>

