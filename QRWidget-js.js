//$("document").ready(function() {
				
				// Initially hide the QR codes list
				$(".codediv").hide();
				
				// Show hide QR codes list when select button is clicked
				$(".selectbutton").toggle(function () {
					$(this).nextAll(".codediv").slideDown(200);
				},
				function () {
					$(this).nextAll(".codediv").slideUp(200);
				});
				
				// Select button hover effect
				$(".selectbutton, .codeitem").hover( function () {
					$(this).fadeTo(50, 0.6);
				},
				function () {
					$(this).fadeTo(50, 1);
				});
				
				// Set the new QR code image and name
				$(".codeitem").live("click", function () {
					var name = $(this).attr("name");
					if ($.trim(name) == "")
						name = "untitled";
						
					var url = "<? echo get_site_url(); ?>/wp-content/plugins/QR-Color-Code-Generator-Plugin/QR-Color-Code-Generator/codes/" + $(this).attr("url");
					$(this).parentsUntil(".widget-inside", ".widget-content").find(".codeurl").attr("value", url);
					$(this).parentsUntil(".widget-inside", ".widget-content").find(".codename").attr("value", name);
					$(".codeitem").css("background-color", "#EEE");
					$(this).css("background-color", "white");
		
				});
				
			//});