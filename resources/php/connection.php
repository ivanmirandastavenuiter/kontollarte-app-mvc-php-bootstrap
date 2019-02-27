<?php

class Connection {
    
    private $dbHostName = "mysql:host=localhost;dbname=kontollarte";
    private $dbUser = "root";
    private $dbPass = "";

    protected static $db;

    protected $connected = false;

    protected $defaultOptions = [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    protected function __construct() {
        $this->makeConnection();
    }

    private function makeConnection() {
        try {
            self::$db = new PDO($this->dbHostName, $this->dbUser, $this->dbPass, $this->defaultOptions);
            $this->connected = true;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    protected function closeConnection() {
        self::$db = null;
        $this->connected = false;
    }

    private function __wakeup() {
        $this->makeConnection();
    }
}
?>
