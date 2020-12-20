<?php

$info = $this->dbaccess->getinfo($_GET['hash']);
if (($info['display'] == 1) && (!isset($_SESSION['userid']))) {
    die('You need to be logged in');
}

if (($_POST['action'] == "getstatus") && (ctype_alnum($_POST['hash']))  ) {
    
        //  setvideo($hash,$url,$height,$width,$totaltime)
        echo json_encode($this->dbaccess->getstatus($_POST['hash']));

}
if (($_POST['action'] == "createclient") && (ctype_alnum($_POST['hash']))) {
        $clienthash = bin2hex(random_bytes(16));
        $this->dbaccess->createclient($_POST['hash'],$clienthash);
        echo $clienthash;
}
if (($_POST['action'] == "updateclient") && (is_numeric($_POST['curtime'])) && (filter_var($_POST['url'], FILTER_VALIDATE_URL)) && (ctype_alnum($_POST['hash'])) && (ctype_alnum($_POST['client'])))  {
        $this->dbaccess->updclient($_POST['hash'],$_POST['url'],$_POST['curtime'],$_POST['client']);
        //  setvideo($hash,$url,$height,$width,$totaltime)
        echo "ok";
}	