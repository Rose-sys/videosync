<?php 
include("inc/database.php");
$db = new dbaccess();
if ($_POST['action'] == "createsession") {
    $hash = bin2hex(random_bytes(16));
    $db->createsession($hash);
    $db->cleanup(5);
    echo $hash;
}
if (($_POST['action'] == "setvideo") && (is_numeric($_POST['totaltime'])) && (is_numeric($_POST['height'])) && (is_numeric($_POST['width'])) && (filter_var($_POST['url'], FILTER_VALIDATE_URL)) && (ctype_alnum($_POST['hash']))  ) {

    if($db->validatesession($_POST['hash'])) {
            $db->setvideo($_POST['hash'],$_POST['url'],$_POST['height'],$_POST['width'],$_POST['totaltime']);
  //  setvideo($hash,$url,$height,$width,$totaltime)
            echo "ok";
    } else {
        
            echo "Session not valid";
    }
}

if (($_POST['action'] == "updatetime") && (is_numeric($_POST['curtime'])) && (ctype_alnum($_POST['hash']))  ) {
    
    if($db->validatesession($_POST['hash'])) {
        $db->updatetime($_POST['hash'],$_POST['curtime']);
        //  setvideo($hash,$url,$height,$width,$totaltime)
        echo "ok";
    } else {
        echo "Session not valid";
    }
}
if (($_POST['action'] == "seek") && (is_numeric($_POST['time'])) && (ctype_alnum($_POST['hash']))  ) {
    
    if($db->validatesession($_POST['hash'])) {
        $db->seek($_POST['hash'],$_POST['time']);
        //  setvideo($hash,$url,$height,$width,$totaltime)
        echo "ok";
    } else {
        echo "Session not valid";
    }
}
if (($_POST['action'] == "play") && (ctype_alnum($_POST['hash']))  ) {
    if($db->validatesession($_POST['hash'])) {
        $db->setplay($_POST['hash']);
        //  setvideo($hash,$url,$height,$width,$totaltime)
        echo "ok";
    } else {
        
        echo "Session not valid";
    }
}

if (($_POST['action'] == "pause") && (ctype_alnum($_POST['hash']))  ) {
    if($db->validatesession($_POST['hash'])) {
        $db->setpause($_POST['hash']);
        //  setvideo($hash,$url,$height,$width,$totaltime)
        echo "ok";
    } else {
        
        echo "Session not valid";
    }
}

if (($_POST['action'] == "getstatus") && (ctype_alnum($_POST['hash']))  ) {
    if($db->validatesession($_POST['hash'])) {
       
        //  setvideo($hash,$url,$height,$width,$totaltime)
        echo json_encode($db->getstatus($_POST['hash']));
    } else { 
        echo "Session not valid";
    }
}

if (($_POST['action'] == "createclient") && (ctype_alnum($_POST['hash']))) {
    if($db->validatesession($_POST['hash'])) {
        $clienthash = bin2hex(random_bytes(16));
        $db->createclient($_POST['hash'],$clienthash);
        echo $clienthash;
    } else {
        //fail silently, do not interrupt script of client
    }
}
if (($_POST['action'] == "updateclient") && (is_numeric($_POST['curtime'])) && (filter_var($_POST['url'], FILTER_VALIDATE_URL)) && (ctype_alnum($_POST['hash'])) && (ctype_alnum($_POST['client'])))  {
    
    if($db->validatesession($_POST['hash'])) {
        $db->updclient($_POST['hash'],$_POST['url'],$_POST['curtime'],$_POST['client']);
        //  setvideo($hash,$url,$height,$width,$totaltime)
        echo "ok";
    } else {
        //fail silently, do not interrupt script of client
    }
}	
?>