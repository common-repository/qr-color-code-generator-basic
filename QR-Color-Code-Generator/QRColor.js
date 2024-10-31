// JavaScript Document

$("head").append('<link href="QR-Color-Code-Generator/style.css" type="text/css" rel="stylesheet"/><link href="QR-Color-Code-Generator/validation/css/validationEngine.jquery.css" rel="stylesheet" type="text/css"><link href="QR-Color-Code-Generator/uploadify/uploadify.css" type="text/css" rel="stylesheet" />');

$("head").append('<link href="QR-Color-Code-Generator/farbtastic/farbtastic.css" rel="stylesheet" type="text/css">');

var geocoder;
		var map;
		var marker;
		var latlong = new google.maps.LatLng(31.9685988, -99.9018131);
		    
		function initialize(){
			//MAP
			var latlng = latlong;
			var options = {
				zoom: 14,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.HYBRID,
				draggable: true,
				scrollwheel: false,
				scaleControl: true,
				disableDoubleClickZoom: true
			};
	        
			map = new google.maps.Map(document.getElementById("map_canvas"), options);
		        
			//GEOCODER
			geocoder = new google.maps.Geocoder();
			    
			marker = new google.maps.Marker({
				map: map,
				draggable: false
			});

			marker.setPosition(latlong);
			map.setCenter(latlong);
        
				
		}
	$(function () {
		initialize();
		$("#address").autocomplete({
					//This bit uses the geocoder to fetch address values
					source: function(request, response) {
						geocoder.geocode( {'address': request.term }, function(results, status) {
							response($.map(results, function(item) {
								return {
									label:  item.formatted_address,
									value: item.formatted_address,
									latitude: item.geometry.location.lat(),
									longitude: item.geometry.location.lng()
								}
							}));
						})
					},
					//This bit is executed upon selection of an address
					select: function(event, ui) {
						$("#latitude").val(ui.item.latitude);
						$("#longitude").val(ui.item.longitude);
												
						var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
						
						latlong = location;
						
						marker.setPosition(location);
						map.setCenter(location);
					}
				});
		
		
		//Add listener to marker for reverse geocoding
			google.maps.event.addListener(marker, 'drag', function() {
				geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						if (results[0]) {
							$('#address').val(results[0].formatted_address);
							$('#latitude').attr(marker.getPosition().lat());
							$('#longitude').val(marker.getPosition().lng());
						}
					}
				});
			});
			
			
		pulsate();
		$(".logoimage, #qrcode").hide();
		$("#loader").hide();
		
		$("#downloadpng, #downloadpdf").click(function (e) {
			if($("#qrcode").attr("src") != "")
			{
				window.location = $(this).attr("src");
				$(".logoimage, #qrcode").hide();
				$(".previewtext").show();
				$("#qrcode").attr("src", "");
			}
				
		});
		
		/////// MAKE CURRENT PAGE BUTTON ACTIVE
		$(".headerbutton:eq(1)").css("color", "#C9E9FF");
		
		$(".page").hide();
		$(".page:first").show();
		$(".menubutton").css("color", "#C9C9C9");
		$(".menubutton:first").css("color", "white");
		$(".menubutton").click( function () {
			$(".page").hide();
			$(".menubutton").css("color", "#C9C9C9");
			$(this).css("color", "white");
			var newPage =  "[page=" + $(this).attr("id") + "]";
			$(newPage).show();
			$("[name=type]").attr("value", $(this).attr("id"));
			initialize();		
			google.maps.event.trigger(map, 'resize');
			

			
		});
		
		////////// WEBSITE FORM VALIDATION
		//////////////////////////////////////////////
		
		 $('.submit').live("click", function(){
			 
			$("#formID").validationEngine({   
			            onValidationComplete: 
							function  (form,status) {
								//alert();
								if (status==true) {			 
								 var x = $.ajax({
  								url: "QR-Color-Code-Generator/generate-qrcode.php",
								dataType: "html",
								data: form.serializeArray(),
								type: "POST",
  								beforeSend: function( xhr ) {
									$("#loader").show();
  								},
  								success: function( data ) {
						
									$("#qrcode").attr("src", "QR-Color-Code-Generator/codes/" + data);
									$(".logoimage, #qrcode").show();
									$("#loader").hide();
									x.abort();
									//$('.submit, #formID').unbind();
									$(".previewtext").hide();
									$("#downloadpng").attr("src", "QR-Color-Code-Generator/codes/downloadpng.php?filename=" + data)
									$("#downloadpdf").attr("src", "QR-Color-Code-Generator/codes/downloadpdf.php?filename=" + data)
																
 								}
							});
						   }
						},
						validationEventTriggers:"submit",   
						inlineValidation: false,
						success :  false,
						failure : function() { callFailFunction()}
            });
                
		});
		
		
		$(".reset").click(function () {
			$("[type=text]:not(#size, [name=foregroundsolidbox], [name=backgroundsolidbox], [name=foregroundstart], [name=foregroundend])").attr("value", "");
			$("textarea").attr("value", "");
			$("#qrcode").attr("src", "");
			$(".logoimage, #qrcode").hide();	
			$(".previewtext").show();
			
		});
		//////////////////////////////////////////////
		//////////////////////////////////////////////
		
		
		//////// SET VALUES OF FOREGROUND AND BACKGROUND COLORS
		$(".foregroundcolors").click(function () {
			//alert($("[name=foreground]").attr("value") + $(this).attr("color"));
			$("[name=foreground]").attr("value", $(this).attr("color"));	
			$(".qrcodeforegroundcolor").css("background-color", "" + $(this).attr("color") +"");
		});
		
		$(".backgroundcolors").click(function () {
			$("[name=background]").attr("value", $(this).attr("color"));	
			$(".qrcodebackgroundcolor").css("background-color", "" + $(this).attr("color") +"");	
			$(".logoimage").css("border", "solid").css("border-width", "10px").css("border-color", $(this).attr("color"));
		});
		
		
		$( ".slider" ).slider({
			range: "max",
			min: 1,
			max: 50,
			value: 10,
			slide: function( event, ui ) {
				$( "#size" ).val( ui.value );
			}
		});
		$( ".size" ).val( $( ".slider" ).slider( "value" ) );
		
		$(".foregroundgradient").css("opacity", "0.6");
		$(".backgroundgradient").css("opacity", "0.6");
		$(".foregroundgradientcontent").hide();
		$(".backgroundgradientcontent").hide();
		$(".foregroundgradient").click(function () {
			$(".foregroundsolid").css("opacity", "0.6");
			$(this).css("opacity","1");
			$("[name=foreground]").attr("value", "gradient");
			$(".foregroundsolidcontent").hide();
			$(".foregroundgradientcontent").show();
			if($('[value=vertical]').is(':checked'))
				{
					$(".qrcodeforegroundcolor").css("background-color", "none").css("background-image", "linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-o-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-moz-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-ms-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-gradient(linear,right top,right bottom,color-stop(0, " + $('[name=foregroundstart]').attr('value')  + "),color-stop(1, " + $('[name=foregroundend]').attr('value')  + "));");
				}
				
				if($('[value=horizontal]').is(':checked'))
				{
					$(".qrcodeforegroundcolor").css("background-color", "none").css("background-image", "linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-o-linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-moz-linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-ms-linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-gradient(linear,left bottom,right bottom,color-stop(0, " + $('[name=foregroundstart]').attr('value')  + "),color-stop(1, " + $('[name=foregroundend]').attr('value')  + "));");
				}
			
		});
		$(".foregroundsolid").click(function () {
			$(".foregroundgradient").css("opacity", "0.6");
			$(this).css("opacity","1");
			$("[name=foreground]").attr("value", "solid");
			$(".foregroundsolidcontent").show();
			$(".foregroundgradientcontent").hide();
			var foregroundcolor = $("[name=foregroundsolidbox]").attr("value");
				$(".qrcodeforegroundcolor").css("background-color", foregroundcolor).css("background-image", "none");
			
			
		});
		
		
		
		
		
		$('.foregroundsolidpicker').farbtastic('[name=foregroundsolidbox]');
		$('.foregroundgradientstartpicker').farbtastic('[name=foregroundstart]');
		$('.foregroundgradientendpicker').farbtastic('[name=foregroundend]');
		$('.backgroundsolidpicker').farbtastic('[name=backgroundsolidbox]');
		
		var uploadedImage = "";
		var newID = "";
		
		$(".logocontainer").hide();
		$("[name=logo]").mouseup(function () {
			
			if($(this).attr("value") == "no")
			{
				$(".logocontainer").hide();
				$(".logoimage").hide();
			}
			if($(this).attr("value") == "yes")
			{
				$(".logocontainer").show();
				$(".logoimage").show();
			}
		});
		
		var foregroundcolor = $("[name=foregroundsolidbox]").attr("value");
		$(".qrcodeforegroundcolor").css("background-color", foregroundcolor);
		var backgroundcolor = $("[name=backgroundsolidbox]").attr("value");
		$(".qrcodebackgroundcolor").css("background-color", backgroundcolor);
		$(".palette").mouseup(function () {
			if($("[name=foreground]").attr("value") == "solid")
			{
				var foregroundcolor = $("[name=foregroundsolidbox]").attr("value");
				$(".qrcodeforegroundcolor").css("background-color", foregroundcolor).css("background-image", "none");
			}
			if($("[name=foreground]").attr("value") == "gradient")
			{
				var startcolor = $("[name=foregroundstart]").attr("value");
				var endcolor = $("[name=foregroundend]").attr("value");
				if($('[value=vertical]').is(':checked'))
				{
					$(".qrcodeforegroundcolor").css("background-color", "none").css("background-image", "linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-o-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-moz-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-ms-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-gradient(linear,right top,right bottom,color-stop(0, " + $('[name=foregroundstart]').attr('value')  + "),color-stop(1, " + $('[name=foregroundend]').attr('value')  + "));");
				}
				
				if($('[value=horizontal]').is(':checked'))
				{
					$(".qrcodeforegroundcolor").css("background-color", "none").css("background-image", "linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-o-linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-moz-linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-ms-linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-gradient(linear,left bottom,right bottom,color-stop(0, " + $('[name=foregroundstart]').attr('value')  + "),color-stop(1, " + $('[name=foregroundend]').attr('value')  + "));");
				}
			}
			var backgroundcolor = $("[name=backgroundsolidbox]").attr("value");
			$(".qrcodebackgroundcolor").css("background-color", backgroundcolor);
			$(".logoimage").css("border", "solid").css("border-width", "10px").css("border-color", backgroundcolor);
		});
		
		$("[value=vertical]").click(function () {
			$(".qrcodeforegroundcolor").css("background-color", "none").css("background-image", "linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-o-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-moz-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-ms-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-gradient(linear,right top,right bottom,color-stop(0, " + $('[name=foregroundstart]').attr('value')  + "),color-stop(1, " + $('[name=foregroundend]').attr('value')  + "));");
					
		});
		
		$("[value=horizontal]").click(function () {
			$(".qrcodeforegroundcolor").css("background-color", "none").css("background-image", "linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-o-linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-moz-linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-linear-gradient(top, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-ms-linear-gradient(left, " + $('[name=foregroundstart]').attr('value')  + " 0%, " + $('[name=foregroundend]').attr('value')  + " 100%)").css("background-image", "-webkit-gradient(linear,left bottom,right bottom,color-stop(0, " + $('[name=foregroundstart]').attr('value')  + "),color-stop(1, " + $('[name=foregroundend]').attr('value')  + "));");
		});
		
		
		
		
	
	});
			function pulsate() {
      $("#loader").animate({opacity: 0.2}, 300,function(){
          $(this).animate({opacity: 1}, 300, null, function() {pulsate()});
      });
     }

	
			
	
	 // This method is called right before the ajax form validation request
            // it is typically used to setup some visuals ("Please wait...");
            // you may return a false to stop the request 
			
            function beforeCall(form, options){
                if (window.console) 
				
                    console.log("Right before the AJAX form validation call");
					
				///////AJAX CALL TO SCRIPT THAT GENERATES QR CODE
				
				$("#loader").show();
                return true;
            }
