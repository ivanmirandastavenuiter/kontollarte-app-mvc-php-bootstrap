<?php 

require_once 'C:\xampp\htdocs\MVC\resources\php\database.php';

class Message {

    private $messageId;
    private $userId;
    private $email;
    private $name;
    private $body;
    private $date;

    public function __construct($messageId, $userId, $email, $name, $body, $date) {
        $this->messageId = $messageId;
        $this->userId = $userId;
        $this->email = $email;
        $this->name = $name;
        $this->body = $body;
        $this->date = $date;
    }

    // Getters / Setters

    public function getEmail() { return $this->email; }
    public function getName() { return $this->name; }
    public function getBody() { return $this->body; }
    public function getDate() { return $this->date; }

    // Magic methods

    public function __isset($property) {
        return isset($this->$property);
    }

    public function __clone() {
        $this->messageId = clone $this->messageId;
        $this->userId = clone $this->userId;
        $this->email = clone $this->email;
        $this->name = clone $this->name;
        $this->body = clone $this->body;
        $this->date = clone $this->date;
    }

    public function __sleep() {
        return array('messageId', 'userId', 'email', 'name', 'body', 'date');
    }

    public function __toString() {
        return "Current message [Message id: $this->messageId],  
                [User id: $this->userId],
                [Email: $this->email],
                [Name: $this->name],
                [Body: $this->body],
                [Date: $this->date]";
    }

    // Custom methods 

    public function insert() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("INSERT INTO mensaje (crpMen, fecMen, idUsu) VALUES
        (:message, now(), :userId)");

        $sqlp->bindParam(":message", $this->body, PDO::PARAM_STR, 1000);
        $sqlp->bindParam(":userId", $this->userId, PDO::PARAM_INT);
        
        $query = $sqlp->execute();

        return $query;
        
    }

    public static function insertMessageAndReceiver($messageId, $receiversIds) {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        foreach($receiversIds as $currentReceiverId) {

            $sqlp = $PDOStatement->prepare("INSERT INTO mensaje_destinatario (idMen, idDes) VALUES
            (:messageId, :receiverId)");
    
            $sqlp->bindParam(":messageId", $messageId->idMen, PDO::PARAM_INT);
            $sqlp->bindParam(":receiverId", $currentReceiverId->idDes, PDO::PARAM_INT);
            
            $sqlp->execute();

        }

    }

    public function delete() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("DELETE FROM mensaje WHERE idMen=:id");

        $sqlp->bindParam(":id", $this->messageId, PDO::PARAM_INT);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;
    }

    public function update() {

        $db = Database::getInstance();
        $PDOStatement = $db->getPDOStatement();

        $sqlp = $PDOStatement->prepare("UPDATE mensaje SET idMen=:id, crpMen=:body, fecMen=:date, 
        idUsu=:userId;"); 

        $sqlp->bindParam(":id", $this->messageId, PDO::PARAM_INT);
        $sqlp->bindParam(":body", $this->body, PDO::PARAM_STR, 3000);
        $sqlp->bindParam(":date", $this->date, PDO::PARAM_STR, 50);
        $sqlp->bindParam(":userId", $this->userId, PDO::PARAM_INT);
        
        $query = $sqlp->execute();
        $sqlp->closeCursor();
        $db->closeConnection();

        return $query;
    }

    public static function getAllMessages($userId):int {

        $db = Database::getInstance();
        $sql = "SELECT COUNT(*) as 'totalMessages' FROM mensaje WHERE idUsu=$userId"; 
        $stdObject = $db->runQuery($sql);

        while ($row = $stdObject->fetchObject()) {
            $quantity = intval($row->totalMessages);
        }

        return $quantity;

    }

    public static function getListOfMessages($userId) {

        $db = Database::getInstance();
        $sql = "SELECT M.idMen, idUsu, emaDes, nomDes, crpMen, fecMen
                    FROM mensaje M JOIN mensaje_destinatario MD
                    ON M.idMen=MD.idMen
                    JOIN destinatario D
                    ON MD.idDes=D.idDes
                    WHERE idUsu=$userId ";

        $result = $db->runQuery($sql);
        $messagesList = array();

        while ($row = $result->fetchObject()) {

            $currentMessage = new Message(
                $row->idMen,
                $row->idUsu,
                $row->emaDes,
                $row->nomDes,
                $row->crpMen,
                $row->fecMen
            );

            array_push($messagesList, $currentMessage);
        }

        return $messagesList;

    }

    public static function getMessageId() {

        $db = Database::getInstance();
        $sql = "SELECT idMen FROM mensaje ORDER BY idMen DESC LIMIT 1";

        $result = $db->runQuery($sql);
        return $result->fetchObject();

    }

}