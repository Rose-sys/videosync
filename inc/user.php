<?php 
class user {
    private $tmplsettings;
    
    function __construct($dbaccess) { 
        $this->dbaccess = $dbaccess; 
    }

    private function verifyuser() {
        return $dbacces->verify($_SESSION['userid'],$_SESSION['password']);
    }

}

?>