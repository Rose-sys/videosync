<?php 
if (!isset($GLOBALS['x'])) {
    die("direct access not allowed");
}


if ($_POST['action'] == "create") {
$hash = bin2hex(random_bytes(16));
    if (!empty($_POST['title'])) {
        $this->dbaccess->createsession($hash,$_SESSION['userid'],$_POST['title']);
    }
} else if ($_POST['action'] == "delete") {
    $this->dbaccess->deletesession();
} else if ($_POST['action'] == "priv") {
    $this->dbaccess->priv($_SESSION['userid'],$_POST['hash']);
} else if ($_POST['action'] == "pub") {
    $this->dbaccess->pub($_SESSION['userid'],$_POST['hash']);
}
