<?php

require_once 'C:\xampp\htdocs\MVC\resources\php\database.php';

class User {

    private $id;
    private $pass;
    private $username;
    private $name;
    private $surname;
    private $email;
    private $phone;
    private $storedGalleries;
    private $isLogged;

    public function __construct($id, $pass, $username, $name, $surname, $email, $phone) {
        if (!is_null($id)) $this->id = $id;
        if (!is_null($pass)) $this->pass = $pass;
        $this->username = $username;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->storedGalleries = array();
        $this->isLogged = false;
    }

    // Getters / Setters

    public function getUsername() { return $this->username; }
    public function getName() { return $this->name; }
    public function getSurname() { return $this->surname; }
    public function getEmail() { return $this->email; }
    public function getPhone() { return $this->phone; }
    public function getStoredGalleries() { return $this->storedGalleries; }
    public function getIsLogged() { return $this->isLogged; }
    private function getPass() { return $this->pass; }
    private function getId() { return $this->id; }

    public function setUsername($username) { $this->username = $username; }
    public function setName($name) { $this->name = $name; }
    public function setSurname($surname) { $this->surname = $surname; }
    public function setEmail($email) { $this->email = $email; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function setStoredGalleries($storedGalleries) { 

        if (is_array($storedGalleries)) {
            $this->storedGalleries = $storedGalleries;
        } else {
            array_push($this->storedGalleries, $storedGalleries); 
        }

    }
        
    public function setIsLogged($isLogged) { $this->isLogged = $isLogged; }

    // Magic methods

    public function __isset($property) {
        return isset($this->$property);
    }

    public function __clone() {
        $this->id = clone $this->id;
        $this->username = clone $this->username;
        $this->name = clone $this->name;
        $this->surname = clone $this->surname;
        $this->email = clone $this->email;
        $this->phone = clone $this->phone;
        $this->storedGalleries = clone $this->storedGalleries;
    }

    public function __sleep() {
        return array('id', 'pass', 'username', 'name', 'surname', 'email', 'phone', 'storedGalleries', 'isLogged');
    }

    public function __toString() {
        return "Current user [Id: $this->id],  
                [Username: $this->username],
                [Name: $this->name],
                [Surname: $this->surname],
                [Email: $this->email],
                [Phone: $this->email],
                [Stored galleries $this->storedGalleries]";
    }

    public function __call($method, $parameters) {
        if (in_array($method, array('getPass', 'getId'))) {
            return call_user_func_array(array($this, $method), $parameters);
        }
    }

    // Custom methods

    public function insert() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("INSERT INTO usuario (pasUsu, aliUsu, nomUsu, apeUsu, emaUsu, telUsu) VALUES
        (:pwd, :username, :name, :surname, :email, :phone)");
        
        $sqlp->bindParam(":pwd", $this->pass, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":username", $this->username, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":name", $this->name, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":surname", $this->surname, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":email", $this->email, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":phone", $this->phone, PDO::PARAM_STR, 100);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    public function delete() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("DELETE FROM usuario WHERE idUsu=:id");

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_INT);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    public function update() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("UPDATE usuario SET pasUsu=:pwd, aliUsu=:username, nomUsu=:name, 
        apeUsu=:surname, emaUsu=:email, telUsu=:phone WHERE idUsu=:id;"); 

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_INT);
        $sqlp->bindParam(":pwd", $this->pass, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":username", $this->username, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":name", $this->name, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":surname", $this->surname, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":email", $this->email, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":phone", $this->phone, PDO::PARAM_STR, 100);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    public function serialize() {
        return serialize($this);
    }

    public static function getUserThroughNameAndPass($username, $pass) {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sql = "SELECT * FROM usuario WHERE aliUsu='$username' AND pasUsu=MD5('$pass')";
        $result = $db->runQuery($sql);
        return $result->fetchObject();

    }

    public static function getPersonalGalleries($id) {

        $db = Database::getInstance();
        $sql = "SELECT G.idGal, nomGal, dirGal, webGal, emaGal FROM usuario_galeria UG
        JOIN galeria G on UG.idUsu = $id AND UG.idGal = G.idGal"; 
    
        $result = $db->runQuery($sql);
        $galleriesList = array();

        while ($row = $result->fetchObject()) {

            $currentGallery = new Gallery(
                $row->idGal,
                $row->nomGal,
                $row->dirGal,
                $row->emaGal,
                $row->webGal
            );

            array_push($galleriesList, $currentGallery);

        }

        return $galleriesList;

    }

    public static function getAllUsers() {

        $db = Database::getInstance();
        $sql = ' SELECT * FROM usuario ';
        return $db->runQuery($sql);

    }
    
}