<?php 

require_once 'C:\xampp\htdocs\MVC\resources\php\database.php';

class Show {

    private $id;
    private $startingDate;
    private $endingDate;
    private $name;
    private $description;
    private $imgInfo;

    public function __construct($id, $startingDate, $endingDate, $name, $description, $imgInfo) {
        $this->id = $id;
        $this->startingDate = $startingDate;
        $this->endingDate = $endingDate;
        $this->name = $name;
        $this->description = $description;
        if (!empty($imgInfo)) $this->imgInfo = $imgInfo; else $this->imgInfo = array();
    }

    // Getters / Setters

    public function getId() { return $this->id; }
    public function getStartingDate() { return $this->startingDate; }
    public function getEndingDate() { return $this->endingDate; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getImgInfo() { return $this->imgInfo; }

    public function setName($name) { $this->name = $name; }
    public function setImgInfo($imgInfo) { $this->imgInfo = $imgInfo; }

    // Magic methods

    public function __isset($property) {
        return isset($this->$property);
    }

    public function __clone() {
        $this->id = clone $this->id;
        $this->startingDate = clone $this->startingDate;
        $this->endingDate = clone $this->endingDate;
        $this->name = clone $this->name;
        $this->description = clone $this->description;
        $this->imgInfo = clone $this->imgInfo;
    }

    public function __sleep() {
        return array('id', 'startingDate', 'endingDate', 'name', 'description', 'imgInfo');
    }

    public function __toString() {
        return "Current show [Id: $this->id],  
                [Starting date: $this->startingDate],
                [Ending date: $this->endingDate],
                [Name: $this->name],
                [Description: $this->description],
                [Image info: $this->imgInfo";
    }

    // Custom methods

    public function insert($order, $userId) {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("INSERT INTO evento (idEve, fecComEve, fecFinEve, nomEve, desEve, ordEve, idUsu) VALUES
        (:id, :startingDate, :endingDate, :name, :description, :order, :userid);");

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_STR, 200);
        $sqlp->bindParam(":startingDate", $this->startingDate, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":endingDate", $this->endingDate, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":name", $this->name, PDO::PARAM_STR, 50);
        $sqlp->bindParam(":description", $this->description, PDO::PARAM_STR, 3000);
        $sqlp->bindParam(":order", $order, PDO::PARAM_INT);
        $sqlp->bindParam(":userid", $userId, PDO::PARAM_INT);
        
        $query = $sqlp->execute();

        return $query;

    }

    public function insertImage() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("INSERT INTO imagen (urlImg, altImg, ancImg, idEve) VALUES
        (:url, :height, :width, :id);");

        $sqlp->bindParam(":url", $this->imgInfo['link'], PDO::PARAM_STR, 200);
        $sqlp->bindParam(":height", $this->imgInfo['height'], PDO::PARAM_INT);
        $sqlp->bindParam(":width", $this->imgInfo['width'], PDO::PARAM_INT);
        $sqlp->bindParam(":id", $this->id, PDO::PARAM_STR, 200);

        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    public function delete() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("DELETE FROM evento WHERE idEve=:id");

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_INT);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }
    
    private static function deleteAll() {
        
        $db = Database::getInstance();
        $sql = " DELETE FROM evento ";
        
        return $db->runQuery($sql);
    }

    public static function getAllShows():int {

        $db = Database::getInstance();
        $sql = "SELECT COUNT(*) as 'totalShows' FROM evento "; 
        $stdObject = $db->runQuery($sql);

        while ($row = $stdObject->fetchObject()) {
            $quantity = intval($row->totalShows);
        }

        return $quantity;

    }

    public static function getShowByOrder($order) {

        $db = Database::getInstance();

        $sql = " SELECT * FROM evento E JOIN imagen I 
                    ON E.idEve = I.idEve
                    WHERE E.ordEve = $order ";

        $result = $db->runQuery($sql);
        $showSelected = $result->fetchObject();

        $imgData = [
            "link" => $showSelected->urlImg,
            "height" => $showSelected->altImg,
            "width" => $showSelected->ancImg
        ];

        $showData = [
            "id" => $showSelected->idEve,
            "startingDate" => $showSelected->fecComEve,
            "endingDate" => $showSelected->fecFinEve,
            "name" => $showSelected->nomEve,
            "description" => $showSelected->desEve,
            "imgData" => $imgData
        ];

        $res = [
            "error" => false,
            "showData" => $showData,
            "newPosition" => $order
        ] ;

        return $res;
    }

}

?>