<?php 
class dbaccess {
        public function __Construct(){}
        private function dbconnect() {
                $this->dbconn = new PDO("mysql:dbname=videosync;host=localhost", "<USERNAME>","<PASSWORD>");
        }
        
        // Verify login
        public function VerifyLogin($username,$password) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("select * from users where username = ?");
            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->execute();
            
            $users = $stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($users['userid'])) {
                if (password_verify($password, $users['password']) == 1) { 
                    $_SESSION['loggedin'] = "yes";
                    $_SESSION['userid'] = $users['userid'];
                    return $users['userid'];
                } else {
                    return false;
                }
            } else {
                return false;
            }
            
        }
        // Create new room
        public function createsession($hash,$uid,$title) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("insert into sessions (sessionid,lastactive,userid,title) values (?,?,?,?)");
            $stmt->bindParam(1, $hash, PDO::PARAM_STR);
            $curtime = time();
            $stmt->bindParam(2, $curtime, PDO::PARAM_INT);
            $stmt->bindParam(3, $uid, PDO::PARAM_INT);
            $stmt->bindParam(4, $title, PDO::PARAM_STR);
            return $stmt->execute();
        }
        
        
        //list rooms under own userid
        public function getrooms($userid) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("select * from sessions where userid = ?");
            $stmt->bindParam(1, $userid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        //delete a room
        public function deletesession($userid,$hash) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("delete from sessions where userid = ? and sessionid = ?");
            $stmt->bindParam(1, $userid, PDO::PARAM_INT);
            $stmt->bindParam(2, $hash, PDO::PARAM_STR);
            $stmt->execute();
        }
        
        //set room to public
        public function pub($userid,$hash) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("UPDATE sessions SET display=0 where userid = ? and sessionid = ?");
            $stmt->bindParam(1, $userid, PDO::PARAM_INT);
            $stmt->bindParam(2, $hash, PDO::PARAM_STR);
            $stmt->execute();
        }
        
        //set room to private
        public function priv($userid,$hash) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("UPDATE sessions SET display=1 where userid = ? and sessionid = ?");
            $stmt->bindParam(1, $userid, PDO::PARAM_INT);
            $stmt->bindParam(2, $hash, PDO::PARAM_STR);
            $stmt->execute();
        }
        
        public function getinfo($hash) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("select * from sessions where sessionid = ?");
            $stmt->bindParam(1, $hash, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        // For master part
        public function validateowner($userid,$hash) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("select sessionid from sessions where sessionid = ? and userid = ?");
            $stmt->bindParam(1, $hash, PDO::PARAM_STR);
            $stmt->bindParam(2, $userid, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                return true;
            } else {
                return false;
            }
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
        
        
        public function updatetime($hash,$time) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("update sessions SET time = ?,lastactive = ? WHERE sessionid = ?");
            $stmt->bindParam(1, $time, PDO::PARAM_INT);
            $curtime = time();
            $stmt->bindParam(2, $curtime, PDO::PARAM_INT);
            $stmt->bindParam(3, $hash, PDO::PARAM_STR);
            
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
        
        public function seek($hash,$time) {
            $this->dbconnect();
            $stmt = $this->dbconn->prepare("update sessions SET time = ?, actionid = actionid + 1,lastactive = ? WHERE sessionid = ?");
            $stmt->bindParam(1, $time, PDO::PARAM_INT);
            $curtime = time();
            $stmt->bindParam(2, $curtime, PDO::PARAM_INT);
            $stmt->bindParam(3, $hash, PDO::PARAM_STR);
            
            $stmt->execute();
        }
        // Client part
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
