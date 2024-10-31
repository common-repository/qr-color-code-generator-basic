<?
/*
Plugin Name: QR Color Code Generator Basic
Plugin URI: http://qrwp.georgeholmesii.com/
Description: Create custom color QR Codes
Version: 1.0
Author: George Holmes II
Author URI: http://qrwp.georgeholmesii.com/
License: GPLv2 or later
*/

//  Copyright 2012  George Holmes II  (email : georgeholmesii@gmail.com)

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


// QR Color Code Generator Widget
/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 */
class QRWidget extends WP_Widget 
{
	function QRWidget ()
	{
		/* Widget settings. */
		$widget_options = array(
			'classname' => 'QR-Color-Code',
			'description' => 'Display QR Color Code',
			'codeurl' => '');
		/* Create the widget. */	
		parent::WP_Widget('QR_Widget', 'QR Color Code', $widget_options);
	}
	/* Display widget on the front end */
	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		
		/* Our variables from the widget settings. */
		$title = ($instance['title']) ? $instance['title'] : 'QR Code';
		$body = ($instance['body']) ? $instance['body'] : '';
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		echo $before_title . $title . $after_title;
		
		/* Display QR Code */
		$code = $instance['codeurl'];
		echo "<p>" . $body . "<img style='margin-left:auto; position:relative; margin-right:auto;' height='150' width='150' src='" . $code . "' /> </p>";
		echo $instance['codedescription'];
	}
	
	/*
	function update($new_instance, $old_instance)
	{
		
	}
	*/
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function when creating form elements
	 */
	function form($instance)
	{
		?>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		
        <style type="text/css">
.selectbutton {
	float:left;
	position:relative;
	text-align:center;
	width:200px;
	height:10px;
	padding:8px;
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


.selectbuttonpressed {
	float:left;
	position:relative;
	text-align:center;
	width:200px;
	height:10px;
	padding:8px;
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

.codediv {
	width:195;
	height:300px;
	overflow:auto;
	background-color:#EEE;	
	box-shadow: 0px 1px 2px 2px #999;
	-moz-box-shadow: 0px 1px 2px 2px #999;
	-webkit-box-shadow: 0px 1px 2px 2px #999;
	-o-box-shadow: 0px 1px 2px 2px #999;
	-ms-box-shadow: 0px 1px 2px 2px #999;
}
		
.codeitem {
	height:30px;
	width:100%;
	padding-top:5px;
	border-bottom:solid;
	border-width:2px;
	border-color:black;
	
	font-size: 13px;
	cursor:pointer;
	background-color:#EEE;
			
}
		
.currentcodediv {
	width:100%;
	height:60px;
	padding:5px;
	background-image: linear-gradient(bottom, #F7F7F7 89%, #E6E6E6 100%);
	background-image: -o-linear-gradient(bottom, #F7F7F7 89%, #E6E6E6 100%);
	background-image: -moz-linear-gradient(bottom, #F7F7F7 89%, #E6E6E6 100%);
	background-image: -webkit-linear-gradient(bottom, #F7F7F7 89%, #E6E6E6 100%);
	background-image: -ms-linear-gradient(bottom, #F7F7F7 89%, #E6E6E6 100%);

	background-image: -webkit-gradient(
	linear,
	left bottom,
	left top,
	color-stop(0.89, #F7F7F7),
	color-stop(1, #E6E6E6)
	);
	box-shadow: inset 1px 1px 1px 2px #CCC;
	-moz-box-shadow: inset 1px 1px 1px 2px #CCC;
	-webkit-box-shadow: inset 1px 1px 1px 2px #CCC;
	-o-box-shadow: inset 1px 1px 1px 2px #CCC;
	-ms-box-shadow: inset 1px 1px 1px 2px #CCC;

}

#currentcodeimage {
	float:left;
	margin:5px;	
}

#currentcodename {
	font-size:18px;	
}
        </style>
        <?
		/* Set up some default widget settings. */
		$defaults = array( 'codeurl' => '', 'codename' => '', 'codedescription' => 'Description of this QR code' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?> 
        <!-- QR Color Code Title Widget input -->
        <label>QR Color Code Widget Title </label>
        <input type="text" id="<? echo $this->get_field_id('title');?>" name="<? echo $this->get_field_name('title');?>" value="<? echo esc_attr($instance['title']);?>" style="width:100%;"/></br> </br> 
        
        
        <!-- Button that will display the list of QR codes -->
        <div class = "selectbutton">Select QR Code to display</div>
        
        <!-- QR Code image url input -->
        <input type="hidden" class="codeurl" id="<? echo $this->get_field_id('codeurl');?>" name="<? echo $this->get_field_name('codeurl');?>" value="<? echo esc_attr($instance['codeurl']);?>"/> 
        <input type="hidden" class="codename" id="<? echo $this->get_field_id('codename');?>" name="<? echo $this->get_field_name('codename');?>" value="<? echo esc_attr($instance['codename']);?>"/></br> </br> </br>
        
        <div class="currentcodediv"><img id='currentcodeimage' width='50' height='50' src="<? echo esc_attr($instance['codeurl']);?>"/><span style="top:25px; position:relative;" id='currentcodename'><? echo esc_attr($instance['codename']);?></span></div></br>
        <div class="codediv">
        <?
			/* Display selection of QR codes */
			global $wpdb; 
			$table_name = $wpdb->prefix . "qrcolorcodes";
			$qrcodes_records = $wpdb->get_results( "SELECT * FROM " . $table_name );
			foreach ( $qrcodes_records as $qrcodes_record )
			{
				/* Check if QR Code name is NULL; if so display it's name as "untitled". */
				if (trim($qrcodes_record->qrcode_name) == "")
				{
					$name = "untitled";
				}
				else
				{
					$name = $qrcodes_record->qrcode_name;
				}
					
				echo "<div class='codeitem' name='" . $name . "' url='" . $qrcodes_record->qrcode_url . "'><img style='float:left; margin-left:3px;' height='24' width='24' src='" . get_site_url() . "/wp-content/plugins/qr-color-code-generator-basic/QR-Color-Code-Generator/codes/" . $qrcodes_record->qrcode_url . "' /><div style='position:relative; top:5px;'>&nbsp;" . $name . "</div></div>";
			}
		
		?>
        
        
        </div></br>
        <!-- QR Code code description input -->
        <label">QR Code Description</label>
        <textarea id="<? echo $this->get_field_id('codedescription');?>" name="<? echo $this->get_field_name('codedescription');?>" style="width:100%;"><? echo esc_attr($instance['codedescription']);?></textarea>
        <script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
        <script type="text/javascript">
			//$("document").ready(function() {
			
	
				// Initially hide the QR codes list
				$(".codediv").hide();
				
				// Show hide QR codes list when select button is clicked
				
				$(".selectbutton").live("click", function () {
    				// run js after widget dropped into sidebar area
					$(this).attr("class", "selectbuttonpressed");
					$(".selectbuttonpressed").toggle( function () {
						$(this).nextAll(".codediv").slideDown(200);
					},
					function () {
						$(this).nextAll(".codediv").slideUp(200);
					});
				});


				/*
				$(".selectbutton").live("click",function () {
					var display = $(this).nextAll(".codediv").css("display");
					if (display == "block")
					{
						$(this).nextAll(".codediv").slideUp(200);
						return;
					}
					else
						$(this).nextAll(".codediv").slideDown(200);
				});
		
				*/
				
				
				// Select button hover effect
				$(".selectbutton, .selectbuttonpressed, .codeitem").live("mouseover", function () {
					$(this).fadeTo(50, 0.6);
				});
				$(".selectbutton, .selectbuttonpressed, .codeitem").live("mouseleave", function () {
					$(this).fadeTo(50, 1);
				});
				
				// Set the new QR code image and name
				$(".codeitem").live("click", function () {
					var name = $(this).attr("name");
					if ($.trim(name) == "")
						name = "untitled";
						
					var url = "<? echo get_site_url(); ?>/wp-content/plugins/qr-color-code-generator-basic/QR-Color-Code-Generator/codes/" + $(this).attr("url");
					$(this).parentsUntil(".widget-inside", ".widget-content").find(".codeurl").attr("value", url);
					$(this).parentsUntil(".widget-inside", ".widget-content").find(".codename").attr("value", name);
					$(".codeitem").css("background-color", "#EEE");
					$(this).css("background-color", "white");
		
				});
				
			
			//});
			
		</script>
		<?
		
	}
	
	
}

function load_custom_wp_admin_script(){
        wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_script');


function QRWidget_init()
{
	register_widget("QRWidget");	
}
add_action('widgets_init', 'QRWidget_init');

// QR Color Code Generator Plugin

function QRColor_activate()
{
	global $wpdb;
	$table_name = $wpdb->prefix . "qrcolorcodes";
	$table_name2 = $wpdb->prefix . "bitly_creds";
	if ($wpdb->get_var('SHOW TABLES LIKE ' . $table_name) != $table_name)
	{
		$sql = 'CREATE TABLE ' . $table_name . '(
		qrcode_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		qrcode_name TEXT NOT NULL,
		qrcode_url TEXT NOT NULL,
		qrcode_type TEXT NOT NULL
		)';
		
		
		$sql2 = 'CREATE TABLE ' . $table_name2 . '(
		bitly_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		bitly_username TEXT NOT NULL,
		bitly_key TEXT NOT NULL
		)';
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		dbDelta($sql2);
		$wpdb->insert($table_name2, array('bitly_username' => 'username', 'bityly_key' => 'key'));
	}
	
	
	
}

function QRColor_deactivate()
{
	
	
}

register_activation_hook(__FILE__, 'QRColor_activate');
register_deactivation_hook(__FILE__, 'QRColor_deactivate');

function create_codes_page()
{
	?>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <script type="text/javascript">
	$("document").ready(function() {
		
	});
	
	</script>
    <div class="wrap">
    <img style="float:left; margin-right:15px; width:60px; height:60px;" src="../wp-content/plugins/qr-color-code-generator-basic/images/code.png"/>
    <h1 style="color:#999999; text-shadow: 0px 1px 0px #e5e5ee;"> Create QR Codes</h1>
    <h3 style="color:#999999; text-shadow: 0px 1px 0px #e5e5ee;">Here you can generate QR Codes.</h3>
    </div>
    <iframe width="1010" height="1900" src="../wp-content/plugins/qr-color-code-generator-basic/create-code.php"></iframe>
    <? 
}

function manage_codes_page()
{
	?>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <script type="text/javascript">
	$("document").ready(function() {
		
	});
	
	</script>
    <div class="wrap">
    <img style="float:left; margin-right:15px; width:60px; height:60px;" src="../wp-content/plugins/qr-color-code-generator-basic/images/code.png"/>
    <h1 style="color:#999999; text-shadow: 0px 1px 0px #e5e5ee;"> Manage QR Codes</h1>
    <h3 style="color:#999999; text-shadow: 0px 1px 0px #e5e5ee;">Click QR codes to zoom.</h3>
    </div>
    <iframe width="850" height="600" src="../wp-content/plugins/qr-color-code-generator-basic/manage-codes.php"></iframe>
    <? 
}



function help_page()
{
	?>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <script type="text/javascript">
	$("document").ready(function() {
		
	});
	
	</script>
    <div class="wrap">
  
    </div>
    <iframe width="950" height="2300" src="../wp-content/plugins/qr-color-code-generator-basic/QR-Color-Code-Generator/Documentation/help.html"></iframe>
    <? 
}

function QRColor_menu ()
{
	add_menu_page('QR Color Code Generator', 'QR Color Code Generator', 'manage_options', __FILE__,'create_codes_page', '../wp-content/plugins/qr-color-code-generator-basic/images/code-icon.png');
	add_submenu_page(__FILE__, 'Create QR Codes','Create QR Codes','manage_options',__FILE__,'create_codes_page');
	add_submenu_page(__FILE__, 'Manage QR Codes','Manage QR Codes','manage_options','Manage-QR-Codes','manage_codes_page');
	add_submenu_page(__FILE__, 'Help','Help','manage_options','Help','help_page');
}

add_action('admin_menu', 'QRColor_menu');
function QRcolor_shortcode ()
{
	echo '<iframe width="1010" height="1900" src="' . get_site_url() . '/wp-content/plugins/qr-color-code-generator-basic/create-code.php"></iframe>';
}

add_shortcode("QRColor", "QRcolor_shortcode");

?>