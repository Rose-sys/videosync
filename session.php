<?php 
require_once("inc/boot.php");

$html = new html();

$html->loadhtml("Video Loader");
$html->loaddefaults();
$html->loadjs("js/videocontrol.js");
$html->loadcss("css/default.css");
$html->loadbody();


?>
<div id="session"></div>
<div class="floatleft"><input type="text" id="url" name="url"></div>
<div class="floatleft"><button name="loadvid" value="Open video" onclick="openvid();">Open video</button></div>
<div class="floatleft"><button name="loadvid" value="Open video" onclick="playvid();">Play video</button></div>
<div class="floatleft"><button name="loadvid" value="Open video" onclick="pausevid();">Pause video</button></div>
<div class="space"></div>
<div class="slidecontainer">
  <input type="range" min="0" max="100" value="1" class="slider" id="time">
</div>
<video id="master" width="320" height="240" controls>
	<source src="" type="video/webm">
	Maybe you should upgrade your browser.
</video><div class="messagebox">Loading and retrieving meta data of video...</div>
<div class="blackout"></div>

<?php
    $html->enddoc();
?>