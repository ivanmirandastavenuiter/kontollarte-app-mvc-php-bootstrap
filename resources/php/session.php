<?php 

class Session {

    private static $instance = null;
    private static $expirationTime;

    private $userLogged = false;

    private function __construct() { }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function allowAccess() {
        $this->getUserLogged();
        $this->getExpirationTime();

        // Optional lines to check session behavior

        // echo 'Time of last action: '.self::$expirationTime.'</br>;
        // echo 'Time of inactivity: '.(time() - self::$expirationTime) / 60;

        if ((time() - self::$expirationTime) / 60 < 15
                || !$this->userLogged) {
            return true;
        } else {
            $this->kill();
        }
    }

    public function launch() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function __call($method, $parameters) {
        if (in_array($method, array('kill'))) {
            return call_user_func_array(array($this, $method), $parameters);
        }
    }

    private function kill() {
        self::$instance = null;
        $_SESSION = null;
        session_destroy();
        header('Location: index.php?mod=user&op=login');
    }

    public function setNewValue($indexName, $valueName, $serialize = false) {

        if (is_object($valueName) && !$this->userLogged && get_class($valueName) == 'User') {
            $this->setUserLogged();;
        }

        if ($serialize) {
            $_SESSION[$indexName] = serialize($valueName);
            
        } else {
            $_SESSION[$indexName] = $valueName;
        }

        $this->updateLastActivityTime();
    }

    public function getValueByIndex($indexName, $unserialize = false) {

        if ($this->checkIfIndexExists($indexName)) {

            if ($unserialize) {
                return unserialize($_SESSION[$indexName]);
            } else {
                return $_SESSION[$indexName];
            }

        }

        $this->updateLastActivityTime();
    }

    public function checkIfIndexExists($indexName):bool {

        if (isset($_SESSION[$indexName])) {
            return true;
        } else {
            return false;
        }

    }

    public function updateLastActivityTime() {
        self::$expirationTime = time();
        $_SESSION['expiration-time'] = self::$expirationTime;
    }

    private function getExpirationTime() {
        if (isset($_SESSION['expiration-time'])) {
            self::$expirationTime = $_SESSION['expiration-time'];
        }
        return self::$expirationTime;
    }

    public function setUserLogged() {
        $this->userLogged = true;
        $_SESSION['user-logged'] = $this->userLogged;
    }

    private function getUserLogged() {
        if (isset($_SESSION['user-logged'])) { 
            $this->userLogged = $_SESSION['user-logged'];
        }   
    }

}

?>
