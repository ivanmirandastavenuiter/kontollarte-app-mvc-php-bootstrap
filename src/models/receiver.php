<?php  

require_once 'C:\xampp\htdocs\MVC\resources\php\database.php';

class Receiver {

    private $id;
    private $email;
    private $name;

    public function __construct($id, $email, $name) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
    } 

    // Getters / Setters

    public function getEmail() { return $this->email; }
    public function getName() { return $this->name; }

    // Magic methods

    public function __isset($property) {
        return isset($this->$property);
    }

    public function __clone() {
        $this->id = clone $this->id;
        $this->email = clone $this->email;
        $this->name = clone $this->name;
    }

    public function __sleep() {
        return array('id', 'email', 'name');
    }

    public function __toString() {
        return "Current receiver [Receiver id: $this->id],  
                [Email: $this->email],
                [Name: $this->name]";
    }

    // Custom methods

    public function insert() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("INSERT INTO destinatario (emaDes, nomDes) VALUES
        (:email, :name)");

        $sqlp->bindParam(":email", $this->email, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":name", $this->name, PDO::PARAM_STR, 100);
        
        $query = $sqlp->execute();

        return $query;

    }

    public function delete() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("DELETE FROM destinatario WHERE id=:id");

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_INT);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    public function update() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("UPDATE mensaje SET idDes=:id, emaDes=:email, nomDes=:name;"); 

        $sqlp->bindParam(":id", $this->id, PDO::PARAM_INT);
        $sqlp->bindParam(":email", $this->email, PDO::PARAM_STR, 100);
        $sqlp->bindParam(":name", $this->name, PDO::PARAM_STR, 100);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;

    }

    public static function getReceiversIds($receiversList) {

        $db = Database::getInstance();
        $receiversIds = array();

        foreach ($receiversList as $currentReceiver) {
            $sql = " SELECT idDes FROM destinatario WHERE nomDes='".$currentReceiver->getName()."' ";
            $result = $db->runQuery($sql);
            array_push($receiversIds, $result->fetchObject());
        }

        return $receiversIds;
        
    }

    public static function getAllReceivers() {
        
        $db = Database::getInstance();
        $sql = "SELECT * FROM destinatario ";

        $result = $db->runQuery($sql);
        $receiversList = array();

        while ($row = $result->fetchObject()) {

            $currentReceiver = new Receiver(
                $row->idDes,
                $row->emaDes,
                $row->nomDes
            );

            array_push($receiversList, $currentReceiver);
        }

        return $receiversList;
    }
}