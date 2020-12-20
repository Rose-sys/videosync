<?php 
if (!isset($_SESSION['userid'])) { 
    die("403");
}

if ($this->dbaccess->validateowner($_SESSION['userid'], $_POST['hash'])) {
    
    // write down the url in the database of current video
    if (($_POST['action'] == "setvideo") && (is_numeric($_POST['totaltime'])) && (is_numeric($_POST['height'])) && (is_numeric($_POST['width'])) && (filter_var($_POST['url'], FILTER_VALIDATE_URL)) && (ctype_alnum($_POST['hash']))  ) {
        $this->dbaccess->setvideo($_POST['hash'],$_POST['url'],$_POST['height'],$_POST['width'],$_POST['totaltime']);
            //  setvideo($hash,$url,$height,$width,$totaltime)
        echo "ok";
    } 
    
    //update time 
    
    
    if (($_POST['action'] == "updatetime") && (is_numeric($_POST['curtime'])) && (ctype_alnum($_POST['hash']))  ) {

            $this->dbaccess->updatetime($_POST['hash'],$_POST['curtime']);
            //  setvideo($hash,$url,$height,$width,$totaltime)
            echo "ok";

    }
  
    //set play
    if (($_POST['action'] == "play") && (ctype_alnum($_POST['hash']))  ) {
            $this->dbaccess->setplay($_POST['hash']);
            //  setvideo($hash,$url,$height,$width,$totaltime)
            echo "ok";
    }
    
    //set pause
    if (($_POST['action'] == "pause") && (ctype_alnum($_POST['hash']))  ) {
            $this->dbaccess->setpause($_POST['hash']);
            //  setvideo($hash,$url,$height,$width,$totaltime)
            echo "ok";
    }
    if (($_POST['action'] == "seek") && (is_numeric($_POST['time'])) && (ctype_alnum($_POST['hash']))  ) {
 
            $this->dbaccess->seek($_POST['hash'],$_POST['time']);
            //  setvideo($hash,$url,$height,$width,$totaltime)
            echo "ok";
 
    }
} else {
    echo "403,2";
}

