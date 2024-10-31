<?
include_once('../../../wp-config.php');
include_once('../../../wp-load.php');
include_once('../../../wp-includes/wp-db.php');
global $wpdb; 
$table_name = $wpdb->prefix . "bitly_creds";
if (isset($_REQUEST['username']))
{
	$wpdb->query($wpdb->prepare("DELETE FROM " . $table_name));
	$wpdb->insert($table_name, array('bitly_username' => $_REQUEST['username'], 'bitly_key' => $_REQUEST['key']));
	echo "success";
	exit();
}

$bitly_row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $table_name)); 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Settings</title>
</head>

<body>
<div id="settingscontent">
	
    <h3>Bitly Information</h3>
	<form name="form1" method="POST" class="formular" action="QR-Color-Code-Generator/generate-qrcode.php" id="formID">

		Username</br>
		<input type="text" value="<? echo $bitly_row->bitly_username; ?>" name="username" class="validate[required] text-input" id="username"  style="width:300px;"/></br></br>
        API Key</br>
    	<input type="text" value="<? echo $bitly_row->bitly_key; ?>" name="key" class="validate[required] text-input" id="key"  style="width:300px;"/></br></br>
        <div style="width:300px; font-size:14px;">Enter your Bitly username and API key which you can get from <a href="http://bitly.com/a/your_api_key/">here</a>. Then you will be able to use the shorten URL function and track QR codes at Bitly.com.</div></br>
		<input class="submit" type="submit" value="Save">
	</form>
    
</div>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="QR-Color-Code-Generator/validation/js/languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="QR-Color-Code-Generator/validation/js/jquery.validationEngine.js"></script>
<link href="QR-Color-Code-Generator/style.css" type="text/css" rel="stylesheet"/>
<link href="QR-Color-Code-Generator/validation/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	$("document").ready(function() {
		$('.submit').live("click", function(){
			 
			$("#formID").validationEngine({   
			            onValidationComplete: function  (form,status) {
							if(status == true)
									{
                   						$.ajax({
  											url: "settings.php",
											dataType: "text",
											data: form.serializeArray(),
											type: "POST",
  											beforeSend: function( xhr ) {
  											},
  											success: function(data) {
												if($.trim(data) == "success")
												{
													$('#success').remove();
													$("#settingscontent").append("<div id='success'></br>Bitly Credentials Saved Successfully</div>");
													$("#success").fadeTo(1000, 0, 'linear', function () { $("#success").remove(); });
												}
																													
 											}
										});		
									}
	
						},
						validationEventTriggers:"submit",   
						inlineValidation: false,
						success :  false
            });
                
		});
		
		
		
	});
	
</script>
	<style type="text/css">
#settingscontent {
	padding:15px;
	margin-left:auto;
	margin-right:auto;
	position:relative;
	width:900px;
	min-height:1000px;
	
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

}
</style>
</body>
</html>