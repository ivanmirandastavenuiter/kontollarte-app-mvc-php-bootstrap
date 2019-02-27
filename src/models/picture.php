<?php 

require_once 'C:\xampp\htdocs\MVC\resources\php\database.php';

class Picture {

    private $id;
    private $title;
    private $date;
    private $description;
    private $image;
    private $userId;

    public function __construct($id, $title, $date, $description, $image, $userId) {
        if (!is_null($id)) $this->id = $id;
        $this->title = $title;
        $this->date = $date;
        $this->description = $description;
        $this->image = $image;
        $this->userId = $userId;
    }

    // Getters / Setters

    public function getTitle() { return $this->title; }
    public function getDate() { return $this->date; }
    public function getDescription() { return $this->description; }
    public function getImage() { return $this->image; }
    public function getId() { return $this->id; }

    public function setTitle($title) { $this->title = $title; }
    public function setDate($date) { $this->date = $date; }
    public function setDescription($description) { $this->description = $description; }
    public function setImage($image) { $this->image = $image; }

    // Magic methods

    public function __isset($property) {
        return isset($this->$property);
    }

    public function __clone() {
        $this->id = clone $this->id;
        $this->title = clone $this->title;
        $this->date = clone $this->date;
        $this->description = clone $this->description;
        $this->image = clone $this->image;
        $this->userId = clone $this->userId;
    }

    public function __sleep() {
        return array('id', 'title', 'date', 'description', 'image', 'userId');
    }

    public function __toString() {
        return "Current picture [Id: $this->id],  
                [Title: $this->title],
                [Date: $this->date],
                [Description: $this->description],
                [Image: $this->image],
                [User id: $this->userId";
    }

    // Custom methods

    public function insert() {
        
        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("INSERT INTO obra (nomObr, fecObr, desObr, imgObr, idUsu) VALUES
        (:title, :date, :description, :image, :id);");

        $sqlp->bindParam(":title", $this->title, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":date", $this->date, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":description", $this->description, PDO::PARAM_STR, 500);
        $sqlp->bindParam(":image", $this->image, PDO::PARAM_STR, 50);
        $sqlp->bindParam(":id", $this->userId, PDO::PARAM_INT);

        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;
    }

    public function delete() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("DELETE FROM obra WHERE idObr=:id");

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_INT);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    public function update() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("UPDATE obra SET nomObr=:title, fecObr=:date, desObr=:description, 
        imgObr=:image WHERE idUsu=:userid AND idObr=:pictureid;"); 

        $sqlp->bindParam(":title", $this->title, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":date", $this->date, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":description", $this->description, PDO::PARAM_STR, 500);
        $sqlp->bindParam(":image", $this->image, PDO::PARAM_STR, 50);
        $sqlp->bindParam(":userid", $this->userId, PDO::PARAM_INT);
        $sqlp->bindParam(":pictureid", $this->id, PDO::PARAM_INT);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    public static function getAllPicturesThroughId($userId) {

        $db = Database::getInstance();
        $sql = "SELECT * FROM obra WHERE idUsu=".$userId;

        return $result = $db->runQuery($sql);

    }

    public static function getPicturesThroughId($userId) {

        $db = Database::getInstance();
        $limit = self::countAllPictures();

        if ($limit < 2) {
            $sql = "SELECT * FROM obra WHERE idUsu=$userId LIMIT $limit;";
        } else {
            $sql = "SELECT * FROM obra WHERE idUsu=$userId LIMIT 2;";
        }

        return $result = $db->runQuery($sql);

    }

    public static function getMorePictures($userId, $imagesToLoad, $imagesLoaded) {

        $db = Database::getInstance();
        $sql = "SELECT * FROM obra WHERE idUsu=".$userId." LIMIT $imagesLoaded, $imagesToLoad;"; 

        return $result = $db->runQuery($sql);

    }

    public static function countAllPictures():int {

        $db = Database::getInstance();
        $sql = "SELECT COUNT(*) as 'totalPictures' FROM obra "; 
        $stdObject = $db->runQuery($sql);

        while ($row = $stdObject->fetchObject()) {
            $quantity = intval($row->totalPictures);
        }

        return $quantity;

    }

    public static function refreshPictures($userId, $imagesToLoad, $imagesLoaded) {

        $db = Database::getInstance();
        if ($imagesToLoad > 0) {
            $sql = "SELECT * FROM obra WHERE idUsu=$userId LIMIT $imagesLoaded, 2;";
        } else {
            $sql = "SELECT * FROM obra WHERE idUsu=$userId LIMIT $imagesLoaded, 1;";
        }

        return $result = $db->runQuery($sql);

    }

}