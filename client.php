<?php 

if ((ctype_alnum($_GET['hash']))  ) {
    require_once("inc/boot.php");
    require_once("inc/database.php");
    $db = new dbaccess();
    if($db->validatesession($_GET['hash'])) {
        $html = new html();
        
        $html->loadhtml("Video Loader");
        $html->loaddefaults();
        $html->loadjs("js/clientcontrol.js");
        $html->loadcss("css/client.css");
        $html->loadbody();
        
        
        ?>
        <div id="hsession"><?php echo $_GET['hash']?></div>
        <video id="master" width="100%" height="100%" controls>
        	<source src="" type="video/webm">
        	Maybe you should upgrade your browser.
        </video><div class="messagebox">Blank</div>
        <div class="blackout"></div>
        
        
        
        <?php
            $html->enddoc();
    } else {
        echo "Session unknown";
    }
} else {
    echo "Session not set";
}
?>