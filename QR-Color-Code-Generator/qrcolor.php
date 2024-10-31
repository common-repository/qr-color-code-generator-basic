<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="QR-Color-Code-Generator/validation/js/languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="QR-Color-Code-Generator/validation/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="QR-Color-Code-Generator/farbtastic/farbtastic.js"></script>
<script type="text/javascript" src="QR-Color-Code-Generator/QRColor.js"></script>

<div class="content">
<div class="menu">
  <div class="menubutton" id="url">URL</div>
  <div class="menubutton" id="email">Email</div>
  <div class="menubutton" id="sms">SMS</div>
  <div class="menubutton" id="phonecall">Phone Call</div>
  <div class="menubutton" id="wifi">WiFi</div>
  <div class="menubutton" id="bookmark">Bookmark</div>
</div>
<div class="reset">Reset</div>
<div style="width:550px;">


<div class="page" page="url">
<h2>URL</h2>
<form name="form1" method="POST" class="formular" action="QR-Color-Code-Generator/generate-qrcode.php" id="formID">
URL&nbsp; </br>
<input placeholder="http://website.com" value=""  type="text" name="data" id="websiteurl"  style="width:100%;"/>
</br>
</br>
</div>

  <div class="page" page="map">
    <h2>Map</h2>
    <div align="left">
      <input type="text" id="address" style="width:100%;" class="input-field required" value="Texas">
    </div>
    <div align="left" id="map_canvas" style="position:relative; width:550px; height: 400px; margin-top: 10px; margin-bottom: 10px;"></div>
    <input type="hidden" name="latitude" id="latitude" class="input-field">
    <input type="hidden" name="longitude" id="longitude" class="input-field">
  </div>
  <div class="page" page="email">
    <h2>Email</h2>
    Email Address&nbsp; </br>
    <input placeholder="address@email.com" value=""  type="text" name="emailaddress" id="emailaddress"  style="width:100%;"/>
    </br>
    </br>
    Subject&nbsp; </br>
    <input value=""  type="text" name="subject" id="subject"  style="width:100%;"/>
    </br>
    </br>
    Body&nbsp; </br>
    <textarea value=""  type="textarea" name="body" cols="1"  rows="5" style="width:100%;"></textarea>
    </br>
    </br>
  </div>
  <div class="page" page="sms">
    <h2>SMS</h2>
    Phone Number&nbsp; </br>
    <input value=""  type="text" name="smsnumber" id="smsnumber"  style="width:100%;"/>
    </br>
    </br>
    Body&nbsp; </br>
    <textarea value=""  type="textarea" name="smsbody" id="smsbody" cols="1"  rows="5" style="width:100%;"></textarea>
    </br>
    </br>
  </div>
  <div class="page" page="phonecall">
    <h2>Phone Call</h2>
    Phone&nbsp; </br>
    <input type="text" name="phone" id="phone"  style="width:100%;"/>
    </br>
    </br>
  </div>
  
  <div class="page" page="wifi">
    <h2>WiFi</h2>
    Wireless SSID&nbsp; </br>
    <input type="text" name="ssid" id="ssid"  style="width:100%;"/>
    </br>
    </br>
    Encryption
    <input name="encryption" type="radio" value="" checked>
    None
    <input name="encryption" type="radio"  value="wep">
    WEP
    <input name="encryption" type="radio"  value="WPA">
    WPA</br>
    </br>
    Password&nbsp; </br>
    <input type="text" name="password" id="password"  style="width:100%;"/>
    </br>
    </br>
  </div>
  <div class="page" page="bookmark">
    <h2>Bookmark</h2>
    Title&nbsp; </br>
    <input type="text" name="bookmarktitle" id="bookmarktitle"  style="width:100%;"/>
    </br>
    </br>
    URL&nbsp; </br>
    <input type="text" name="bookmarkurl" id="bookmarkurl"  style="width:100%;"/>
    </br>
    </br>
  </div>
 
  Name</br>
  <input placeholder="Give this QR code a unique name" type="text" name="QRname" id="QRname" style="width:100%;"/></br></br>
  <label for="size">Size:</label>
  <input type="text" name="size" id="size" class="size" style="background-color:rgba(0,0,0,0); border:0; font-weight:bold;" readonly>
  <div style="width:100%; cursor:pointer;" class="slider"></div>
  </br>
  <input name="type" value="url" type="hidden"/>
  <input name="background" value="solid" type="hidden"/>
  <input name="foreground" value="solid" type="hidden"/>
  <input name="imagefile" value="" type="hidden"/>
 
  </br>
  Correction Level
  <select name="correction">
    <option value="L">L</option>
    <option value="M">M</option>
    <option value="Q">Q</option>
    <option value="H">H</option>
  </select>
  </br>
  </br>
 
  </br>
  <div  class="palette">Choose foreground color
    <div class="foregroundtabsbox">
      <div class="foregroundsolidcontent">
        <div class="foregroundsolidpicker" style="top:50px; position:relative;"></div>
        <input name="foregroundsolidbox" value="#FFFFFF" type="text" class="colorbox" style="color:rgba(255,255,255,0);" readonly>
      </div>
      <div class="foregroundgradientcontent">
        <div style="position:absolute; z-index:50; left: 226px; top: 121px;">
          <input name="direction" type="radio" value="vertical" checked>
          Vertical</br>
          <input type="radio" name="direction"  value="horizontal" >
          Horizontal</div>
        <div class="foregroundgradientstartpicker" style="top:50px; position:relative;"></div>
        <input name="foregroundstart" value="#FFFFFF" type="text" class="colorbox" style="color:rgba(255,255,255,0);" readonly>
        <div style="position:absolute; left: -10px; top: 89px;">Start</div>
        <div class="foregroundgradientendpicker" style="top:50px; position:relative;"></div>
        <input name="foregroundend" value="#FFFFFF" type="text" class="colorbox" style="color:rgba(255,255,255,0);" readonly>
        <div style="position:absolute; left: -12px; top: 297px;">End</div>
      </div>
    </div>
    </br>
    </br>
    </br>
    </br>
    Choose background color
    <div class="backgroundtabsbox">
      <div class="backgroundsolidpicker"  style="top:20px; position:relative;"></div>
      <input style="top:-20px; color:rgba(255,255,255,0);" name="backgroundsolidbox" value="#000000" type="text" class="colorbox" readonly>
    </div>
  </div>
  </br>
  </br>
  </br>
  <input class="submit" type="submit" value="Generate">
</form>
<div id="codecontainer">
  <div align="center" class="previewtext">Preview QR Code</div>
  <div class="qrcodebackgroundcolor" style="top:50px;left:50px;width:250px;height:250px; z-index:30;position:relative;display:block;background-color:white;padding:0;margin:0;">
    <div class="qrcodeforegroundcolor" style="position:relative;top:40px;left:40px;width:170px;height:170px;background-color:black;display:block;padding:0;margin:0;z-index:31;">
      <div class= "logocontainer" style="display: block;position:relative;top:60px;width:50px;height:50px;margin:auto;background-color:rgba(0,0,0,0);opacity:1;z-index:7409;"><img src="" class="logoimage" style="display: block; max-height:40px; max-width:40px;"/></div>
    </div>
  </div>
</div>
<div id="downloadpng">Download PNG</div>
<div id="downloadpdf">Download PDF</div>
<div id="loader" style="z-index:70;">Loading...</div>
</div>

<div class="qrcodecontainer" style="top:145px; left:670px; position:absolute; width:249px; height:230px; z-index:60; padding:0; margin:0; z-index:60; display:block;"><img id="qrcode" height="250" width="250" src="" style="position:relative; top:0px; left:0px; z-index:70;"/></div>
