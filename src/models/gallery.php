<?php

require_once 'C:\xampp\htdocs\MVC\resources\php\database.php';

class Gallery {

    private $name;
    private $region;
    private $id;
    private $email;
    private $site;

    public function __construct($id, $name, $region, $email, $site) {
        $this->id = $id;
        $this->name = $name;
        $this->region = $region;
        $this->email = $email;
        $this->site = $site;
    }

    // Getters / Setters

    public function getName() { return $this->name; }
    public function getRegion() { return $this->region; }
    public function getEmail() { return $this->email; }
    public function getSite() { return $this->site; }
    private function getId() { return $this->id; }

    // Magic methods

    public function __isset($property) {
        return isset($this->$property);
    }

    public function __clone() {
        $this->id = clone $this->id;
        $this->name = clone $this->name;
        $this->region = clone $this->region;
        $this->email = clone $this->email;
        $this->site = clone $this->site;
    }

    public function __sleep() {
        return array('id', 'name', 'region', 'email', 'site');
    }

    public function __toString() {
        return "Current gallery [Message id: $this->id],  
                [Name: $this->name],
                [Region: $this->region],
                [Email: $this->email],
                [Site: $this->site]";
    }

    public function __call($method, $parameters) {
        if (in_array($method, array('getId'))) {
            return call_user_func_array(array($this, $method), $parameters);
        }
    }

    // Custom methods

    public function insert($userId) {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("INSERT INTO galeria (idGal, nomGal, dirGal, emaGal, webGal) VALUES
        (:id, :name, :region, :email, :site)");

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":name", $this->name, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":region", $this->region, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":email", $this->email, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":site", $this->site, PDO::PARAM_STR, 100);
        
        $sqlp->execute();

        $sqlp = $PDOStatement->prepare("INSERT INTO usuario_galeria (idUsu, idGal, altUsu) VALUES
        (:userId, :galleryId, :date)");

        $date = date("m.d.y");
        
        $sqlp->bindParam(":userId", $userId, PDO::PARAM_INT);
        $sqlp->bindParam(":galleryId", $this->id, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":date", $date, PDO::PARAM_STR, 100);
        
        $sqlp->execute();

    }

    public function delete($userId) {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("DELETE FROM usuario_galeria WHERE idGal=:id AND idUsu=:userid");

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":userid", $userId, PDO::PARAM_INT);
        
        $query = $sqlp->execute();

        return $query;
    }

    public function update() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("UPDATE galeria SET idGal=:id, nomGal=:name, dirGal=:region, 
        emaGal=:email, webGal=:site;"); 

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_INT);
        $sqlp->bindParam(":name", $this->name, PDO::PARAM_STR, 3000);
        $sqlp->bindParam(":region", $this->region, PDO::PARAM_STR, 50);
        $sqlp->bindParam(":email", $this->email, PDO::PARAM_INT);
        $sqlp->bindParam(":site", $this->site, PDO::PARAM_STR, 50);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    private static function checkIfGalleryIsStored():bool {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sql = "SELECT * FROM galeria ";
        $result = $db->runQuery($sql);

        while ($row = $result->fetchObject()) {

            if ($row->idGal == $this->id) {
                return false;
            }
        }

        return true;

    }

    public static function getListOfUserGalleries($userId) {

        $db = Database::getInstance();
        $sql = "SELECT G.idGal, nomGal, dirGal, webGal, emaGal FROM usuario_galeria UG
            JOIN galeria G on UG.idUsu = $userId AND UG.idGal = G.idGal";

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

    public static function getAllUserGalleries($userId):int {

        $db = Database::getInstance();
        $sql = "SELECT COUNT(*) as 'totalGalleries' FROM galeria G
                    JOIN usuario_galeria UG
                    on G.idGal=UG.idGal
                    AND UG.idUsu=$userId "; 

        $stdObject = $db->runQuery($sql);

        while ($row = $stdObject->fetchObject()) {
            $quantity = intval($row->totalGalleries);
        }

        return $quantity;

    }

}