<?php 
class view {
    private $tmplsettings;
    
    function __construct($dbaccess) { 
        $this->dbaccess = $dbaccess; 
        $this->$tmplsettings = array();
    }

    private function gettemplate() {
        return $this->$tmplsettings['template'];
    }

    public function setoptions($option, $value) {
        $this->$tmplsettings[$option] = $value;
    }
    public function settemplate($name) {
        $this->$tmplsettings['template'] = $name .".php";   
    }
    public function loadview() {
        if (file_exists("template/". $this->gettemplate())) {
            include("template/". $this->gettemplate());
        } else {
            include("template/404.php");
        }
    }
    public function errview($data) {
        include("template/err.php");
    }
    public function curlmaster($data) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL,"http://localhost/videosync/room/");
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_POSTFIELDS,
        //   "postvar1=value1&postvar2=value2&postvar3=value3");
        
        // In real life you should use something like:
         curl_setopt($ch, CURLOPT_POSTFIELDS,
                  http_build_query($data));
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $server_output = curl_exec($ch);
        
        curl_close ($ch);
        
    }
}

?>
