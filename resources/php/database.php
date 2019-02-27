<?php

require 'connection.php';

/* DUDAS ANTONIO:
 * 
 * ¿Está bien la herencia con Connection?
 * 
 * 
 * 
 * 
 */

class Database extends Connection {

    private static $instance = null;

    public function __construct() {
        parent::__construct();
    }

    public function getStatus() {
        return $this->connected;
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function runQuery($sql) {
        return $result = parent::$db->query($sql);
    }

    public function closeConnection() {
        parent::closeConnection();
    }

    public function getPDOStatement() {
        return parent::$db;
    }
}

?>