<?
include_once('../../../wp-config.php');
include_once('../../../wp-load.php');
include_once('../../../wp-includes/wp-db.php');
global $wpdb; 
if(isset($_REQUEST['qrcode_id']))
{
	$query_id = $_REQUEST['qrcode_id'];
	$table_name = $wpdb->prefix . "qrcolorcodes";
	$wpdb->query($wpdb->prepare("DELETE FROM " . $table_name . " WHERE qrcode_id = " . $query_id));
	echo "success";
	exit();	
}
?>
<html>
<head>
<meta charset="UTF-8">
<title>Manage QR Codes</title>
</head>
<body>
<div id='overlay' style='cursor:pointer; background-color:black; position:absolute; width:100%; height:100%; z-index:10;'> </div>
	
<div id='overlaytop' style='cursor:pointer; position:absolute; width:100%; height:100%; z-index:11;'> </div>


<div id="managecontent">
	<? 	
		/* Set name of table */
		$table_name = $wpdb->prefix . "qrcolorcodes";
		
		/* Get total number of QR codes */
		$total_codes = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM " . $table_name ) );
		
		/* Calculate number of pages */
		$rowsperpage = 32;
		$totalpages = ceil($total_codes / $rowsperpage);
		
		// get the current page or set a default
		if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
   			// cast var as int
   			$currentpage = (int) $_GET['currentpage'];
		} else {
  		 	// default page num
   			$currentpage = 1;
		} // end if
		
		// if current page is greater than total pages...
		if ($currentpage > $totalpages) {
  			 // set current page to last page
   			$currentpage = $totalpages;
		} // end if
		// if current page is less than first page...
		if ($currentpage < 1) {
   			// set current page to first page
  			 $currentpage = 1;
		} // end if
		
		// the offset of the list, based on current page 
		$offset = ($currentpage - 1) * $rowsperpage;

		/* Get results of QR codes*/
		$qrcodes_records = $wpdb->get_results( "SELECT qrcode_id, qrcode_url, qrcode_type, qrcode_name FROM " . $table_name . " LIMIT " . $offset . ", " . $rowsperpage);
		
		foreach ( $qrcodes_records as $qrcodes_record )
		{   
			/* set thumbnail variables */
			if (trim($qrcodes_record->qrcode_name) == "")
				$qrcode_name = "untitled";
			else
				$qrcode_name = $qrcodes_record->qrcode_name;
			$qrcode_type = $qrcodes_record->qrcode_type;
			$qrcode_image = "<img src='QR-Color-Code-Generator/codes/" . $qrcodes_record->qrcode_url . "' height='60' width='60' />";
			$qrcode_id = $qrcodes_record->qrcode_id;
			
			/* Display each thumbnail */
			echo "<div class='thumbdiv' align='center' file='" . $qrcodes_record->qrcode_url . "' id='" . $qrcode_id . "'  name='" . $qrcode_name . "'  type='" . $qrcode_type . "' image='QR-Color-Code-Generator/codes/" . $qrcodes_record->qrcode_url . "'>";
			echo $qrcode_image;
			echo '</br>';
			
			/* Determine if QR code name should be truncated */
			$name_length = strlen($qrcode_name);
			if ( $name_length > 8)
			{
				$qrcode_name = substr($qrcode_name, 0, -($name_length - 6)) . "..."; 
			}
			echo '<div style="margin-top:5px;">' . $qrcode_name;
			echo '</br>';
			echo "<span style='color:gray'>" . $qrcodes_record->qrcode_type . "</span> </div>";
			echo "</div>";
			
		 }
		 
		 // if not on page 1, don't show back links
		if ($currentpage > 1 && $total_codes > 32) {
   			// get previous page num
   			$prevpage = $currentpage - 1;
   			// show < link to go back to 1 page
  			 echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><img style='position:absolute; cursor:pointer; bottom:5px; left:290px; z-index:9;' src='images/leftarrow.png'></a> ";
		} // end if 
		
		// Display number of pages and current page
		echo "<div style='text-align:center; position:absolute; height:30px; width:100px; bottom:15px; left: 365px;'>";
		if ($totalpages == 1)
		{
			echo "Page 1";
		}
		if ($totalpages > 1)
		{
			echo "Page " . $currentpage . " of " . $totalpages;
		}
		echo "</div>";
		
		// if not on last page, show forward and last page links        
		if ($currentpage != $totalpages && $total_codes > 32) {
   			// get next page
   			$nextpage = $currentpage + 1;
    		// echo forward link for next page 
  			 echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'><img style='position:absolute; cursor:pointer; bottom:5px; left:480px; z-index:9;' src='images/rightarrow.png'></a>";
	
		} // end if

	?>
    
</div>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<link href="QR-Color-Code-Generator/style.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
	$("document").ready(function() {
		// Hide lightbox overlay
		$("#overlay, #overlaytop").hide();
		
		// Display lightbox when each thumbnail is clicked
		$(".thumbdiv").click( function () {
			$("#overlay").show().css("opacity", "0.3");
			$("#overlaytop").show();
			
			// Lightbox HTML
			var lightbox = "<div align='center' id='lightbox' qrcodeid='" + $(this).attr('id') + "' style='z-index:20; text-align:center; background-color:white; position:relative; top:60px; width:400px; height:440px; margin-right:auto; margin-left:auto;'><img id='xbutton' src='images/x.png' style='cursor:pointer; position:absolute; top:5px; right:5px; height:20px; width:20px;'/><div style='font-size:20px'>" + $(this).attr('name') + "</div><img file='" + $(this).attr('file') + "' id='codeimage' style='width:350px; height:350px;' src = '" + $(this).attr('image') + "' /></br>" + $(this).attr('type') + "</br><div id='png' class='button'>Download PNG</div><div id='pdf' class='button'>Download PDF</div><div style='opacity:0.6; left:110px;' id='delete' class='button'>Delete QR code</div></div>";
			
			// Download PNG
			$("#png").live("click", function () {
				window.open( "QR-Color-Code-Generator/codes/downloadpng.php?filename=" + $("#codeimage").attr('file'), 'Download PNG');
			});
			
			// Download PDF
			$("#pdf").live("click", function () {
				window.open( "QR-Color-Code-Generator/codes/downloadpng.php?filename=" +  $("#codeimage").attr('file'), 'Download PDF');
			});
			
			// Delete QR code
			$("#delete").live("click", function () {
				var qrcodeID = $("#lightbox").attr('qrcodeid')
				$.ajax({
  							url: "manage-codes.php",
							dataType: "html",
							data: {'qrcode_id' : qrcodeID},
							type: "POST",
  							beforeSend: function( xhr ) {
								
  							},
  							success: function( data ) {
								if($.trim(data) == "success")
								{
									location.reload();
								}
						
 							}
				});
			});
			
			// Close lightbox when x button is clicked
			$("#xbutton").live("click", function () {
				$("#overlay, #overlaytop").hide();
			});
			
			// Display lightbox
			$("#overlaytop").html(lightbox);
			$("#lightbox").css("opacity", "1");
		});
		
		
	});
	
</script>
<style type="text/css">
.button {
	float:left;
	position:relative;
	text-align:center;
	width:85px;
	height:30px;
	margin:5px;
	font-size:13px;
	cursor:pointer;
	background-image: linear-gradient(bottom, rgb(227,227,227) 0%, rgb(250,250,250) 85%, rgb(240,240,240) 100%);
	background-image: -o-linear-gradient(bottom, rgb(227,227,227) 0%, rgb(250,250,250) 85%, rgb(240,240,240) 100%);
	background-image: -moz-linear-gradient(bottom, rgb(227,227,227) 0%, rgb(250,250,250) 85%, rgb(240,240,240) 100%);
	background-image: -webkit-linear-gradient(bottom, rgb(227,227,227) 0%, rgb(250,250,250) 85%, rgb(240,240,240) 100%);
	background-image: -ms-linear-gradient(bottom, rgb(227,227,227) 0%, rgb(250,250,250) 85%, rgb(240,240,240) 100%);

	background-image: -webkit-gradient(
	linear,
	left bottom,
	left top,
	color-stop(0, rgb(227,227,227)),
	color-stop(0.85, rgb(250,250,250)),
	color-stop(1, rgb(240,240,240))
);
	box-shadow: 0px 1px 2px 2px #999;
	-moz-box-shadow: 0px 1px 2px 2px #999;
	-webkit-box-shadow: 0px 1px 2px 2px #999;
	-o-box-shadow: 0px 1px 2px 2px #999;
	-ms-box-shadow: 0px 1px 2px 2px #999;
}

#managecontent {
	padding:15px;
	margin-left:auto;
	margin-right:auto;
	position:relative;
	width:800px;
	min-height:500px;
	
	background-image: linear-gradient(bottom, rgb(250,250,250) 0%, rgb(242,242,242) 100%);
background-image: -o-linear-gradient(bottom, rgb(250,250,250) 0%, rgb(242,242,242) 100%);
background-image: -moz-linear-gradient(bottom, rgb(250,250,250) 0%, rgb(242,242,242) 100%);
background-image: -webkit-linear-gradient(bottom, rgb(250,250,250) 0%, rgb(242,242,242) 100%);
background-image: -ms-linear-gradient(bottom, rgb(250,250,250) 0%, rgb(242,242,242) 100%);

background-image: -webkit-gradient(
	linear,
	left bottom,
	left top,
	color-stop(0, rgb(250,250,250)),
	color-stop(1, rgb(242,242,242))
);


	border:solid;
	border-width:1px;
	border-color:#999999;
	border-radius:6px;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	-o-border-radius:6px;
	-ms-border-radius:6px;
	margin-bottom:10px;
	
		
}	

.thumbdiv {
	height:60px;
	width:60px;
	float:left;
	margin:15px;
	margin-bottom:20px;
	cursor:pointer;	
	padding:5px;
	box-shadow: inset 1px 1px 1px 2px #CCC;
	-moz-box-shadow: inset 1px 1px 1px 2px #CCC;
	-webkit-box-shadow: inset 1px 1px 1px 2px #CCC;
	-o-box-shadow: inset 1px 1px 1px 2px #CCC;
	-ms-box-shadow: inset 1px 1px 1px 2px #CCC;
	color:black;
	text-shadow: 0px 1px 0px #e5e5ee;
	font-size:12px;
}
</style>
</body>
</html>