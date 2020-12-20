<?php 
session_start();
$userid = $this->dbaccess->VerifyLogin($_POST['username'],$_POST['password']);

if ($userid !== false) {
    $_SESSION['userid'] = $userid;
    $_SESSION['password'] = $_POST['password'];
    
    echo "OK"; 
} else {
    echo "FAIL";
}
?>