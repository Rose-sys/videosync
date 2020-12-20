<?php
class dbaccess {
        public function __Construct(){}
        private function dbconnect() {
                $this->dbconn = new PDO("mysql:dbname=videosync;host=localhost", "<USERNAME>","<PASSWORD>");
        }
        public function createsession($hash) {
                $this->dbconnect();
                $stmt = $this->dbconn->prepare("insert into sessions (sessionid,lastactive) values (?,?)");
                $stmt->bindParam(1, $hash, PDO::PARAM_STR);
                $curtime = time();
                $stmt->bindParam(2, $curtime, PDO::PARAM_INT);
                return $stmt->execute();
             
        }
        public function validatesession($hash) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("select sessionid from sessions where sessionid = ?");
            $stmt->bindParam(1, $hash, PDO::PARAM_STR);
            $stmt->execute();
            //echo $stmt->rowCount();
            if ($stmt->rowCount() == 1) {
                return true;
            } else {
                return false;
            }      
        }
        public function updatetime($hash,$time) {
                $this->dbconnect();
                $stmt = $this->dbconn->prepare("update sessions SET time = ?,lastactive = ? WHERE sessionid = ?");
                $stmt->bindParam(1, $time, PDO::PARAM_INT);
                $curtime = time();
                $stmt->bindParam(2, $curtime, PDO::PARAM_INT);
                $stmt->bindParam(3, $hash, PDO::PARAM_STR);
                
                $stmt->execute();
        }
        public function seek($hash,$time) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("update sessions SET time = ?, actionid = actionid + 1,lastactive = ? WHERE sessionid = ?");
            $stmt->bindParam(1, $time, PDO::PARAM_INT);
            $curtime = time();
            $stmt->bindParam(2, $curtime, PDO::PARAM_INT);
            $stmt->bindParam(3, $hash, PDO::PARAM_STR);
            
            $stmt->execute();
        }
        public function setvideo($hash,$url,$height,$width,$totaltime) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("update sessions SET time = 0, action = 0, actionid = 0, url = ?, width = ?, height = ?, lastactive = ?, totaltime = ? WHERE sessionid = ?");
            $stmt->bindParam(1, $url, PDO::PARAM_STR);
            $stmt->bindParam(2, $width, PDO::PARAM_INT);
            $stmt->bindParam(3, $height, PDO::PARAM_INT);
            $curtime = time();
            $stmt->bindParam(4, $curtime, PDO::PARAM_INT);
            $stmt->bindParam(5, $totaltime, PDO::PARAM_INT);
            $stmt->bindParam(6, $hash, PDO::PARAM_STR);
            $stmt->execute();
        }
        public function setplay($hash) {
                $this->dbconnect();
                $stmt = $this->dbconn->prepare("update sessions SET action = 1, actionid = actionid + 1, lastactive = ? WHERE sessionid = ?");
                $curtime = time();
                $stmt->bindParam(1,$curtime, PDO::PARAM_INT);
                $stmt->bindParam(2, $hash, PDO::PARAM_STR);
                $stmt->execute();
        }
        public function setpause($hash) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("update sessions SET action = 0, actionid = actionid + 1, lastactive = ? WHERE sessionid = ?");
            $curtime = time();
            $stmt->bindParam(1,$curtime, PDO::PARAM_INT);
            $stmt->bindParam(2, $hash, PDO::PARAM_STR);
            $stmt->execute();
        }
        public function cleanup($min) {
            $seconds = $min * 60;
            $deletebefore = time() - $seconds;
            $stmt = $this->dbconn->prepare("DELETE FROM sessions WHERE lastactive < ?");
            $stmt->bindParam(1,$deletebefore, PDO::PARAM_INT);
            $stmt->execute();
        }
        public function getstatus($hash) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("select * from sessions where sessionid = ?");
            $stmt->bindParam(1, $hash, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        
        /// Client functions
        public function createclient($hash,$client) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("insert into clients (sessionid,clientid,lastactive) values (?,?,?)");
            $stmt->bindParam(1, $hash, PDO::PARAM_STR);
            $stmt->bindParam(2, $client, PDO::PARAM_STR);
            $curtime = time();
            $stmt->bindParam(3, $curtime, PDO::PARAM_INT);
            return $stmt->execute();
        }
        public function updclient($hash,$url,$curtime,$client) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("update clients SET lastactive = ?,curtime = ?,url = ? WHERE sessionid = ? AND clientid = ?");         
            $actv = time();
            $stmt->bindParam(1, $actv, PDO::PARAM_INT);
            $stmt->bindParam(2, $curtime, PDO::PARAM_STR);
            $stmt->bindParam(3, $url, PDO::PARAM_STR);
            $stmt->bindParam(4, $hash, PDO::PARAM_STR);
            $stmt->bindParam(5, $client, PDO::PARAM_STR);
   

            return $stmt->execute();
        }
}

