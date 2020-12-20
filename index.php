<?php 
session_start();
$GLOBALS['x'] = 1;


include("inc/view.php");
include("inc/dbfunctions.php");
include("inc/user.php");
$dbaccess = new dbaccess();
$view = new view($dbaccess);
$user = new user($dbaccess);
$view->setoptions("title", "VideoSync");

if (!isset($_GET['a'])) {
    // check if logged in and redirect to main page, or to login page
    if (isset($_SESSION['userid']) && $_SESSION['userid'] !== "") {
        $view->settemplate("main");
    } else {
        $view->settemplate("login");
    }
} elseif (ctype_alnum($_GET['a'])) {
    if ($_GET['a'] == "room") {
        $view->settemplate("room");
    } elseif ($_GET['a'] == "getdata") {
        $view->settemplate("getdata");
    } elseif ($_GET['a'] == "pushdata") {
        $view->settemplate("pushdata");
    } elseif ($_GET['a'] == "verify") {
        $view->settemplate("verify");
    } elseif (isset($_SESSION['userid']) && $_SESSION['userid'] !== "") {
        $view->settemplate($_GET['a']);
    } else {
        $view->settemplate("login");
    }
} else {
    $view->errview("Guru Meditation #00000001.48454C50");
    die();
}
$view->loadview();
?>