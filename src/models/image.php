<?php

require_once 'C:\xampp\htdocs\MVC\resources\php\database.php';

class Image {

    private $id;
    private $url;
    private $height;
    private $width;
    private $showId;

    public function __constructor($id, $url, $height, $width, $showId) {
        if (!is_null($id)) $this->id = $id;
        $this->url = $url;
        $this->height = $height;
        $this->width = $width;
        $this->showId = $showId;
    }

    // Getters / Setters

    public function getUrl() { return $this->url; }
    public function getHeight() { return $this->height; }
    public function getWidth() { return $this->width; }

    // Magic methods

    public function __isset($property) {
        return isset($this->$property);
    }

    public function __clone() {
        $this->id = clone $this->id;
        $this->url = clone $this->url;
        $this->height = clone $this->height;
        $this->width = clone $this->width;
        $this->showId = clone $this->showId;
    }

    public function __sleep() {
        return array('id', 'url', 'height', 'width', 'showId');
    }

    public function __toString() {
        return "Current image [Id: $this->id],  
                [Url: $this->url],
                [Height: $this->height],
                [Width: $this->width],
                [Show id: $this->showId]";
    }

    // Custom methods

    public function insert() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("INSERT INTO imagen (urlImg, altImg, ancImg, idEve) VALUES
        (:url, :height, :width, :id);");

        $sqlp->bindParam(":url", $this->url, PDO::PARAM_STR, 200);
        $sqlp->bindParam(":height", $this->height, PDO::PARAM_INT);
        $sqlp->bindParam(":width", $this->width, PDO::PARAM_INT);
        $sqlp->bindParam(":id", $this->id, PDO::PARAM_STR, 200);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    public function delete() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("DELETE FROM imagen WHERE idImg=:id");

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_INT);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;
    }

    public function update() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("UPDATE imagen SET urlImg=:url, altImg=:height, ancImg=:width, 
        idEve=:id"); 

        $sqlp->bindParam(":url", $this->url, PDO::PARAM_STR, 200);
        $sqlp->bindParam(":height", $this->height, PDO::PARAM_INT);
        $sqlp->bindParam(":width", $this->width, PDO::PARAM_INT);
        $sqlp->bindParam(":id", $this->showId, PDO::PARAM_INT);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }
}

?>