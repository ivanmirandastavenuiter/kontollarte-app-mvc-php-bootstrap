<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\Users\Iván\vendor\autoload.php';

require_once 'C:\xampp\htdocs\MVC\src\models\message.php';
require_once 'C:\xampp\htdocs\MVC\src\models\gallery.php';
require_once 'C:\xampp\htdocs\MVC\src\models\picture.php';
require_once 'C:\xampp\htdocs\MVC\src\models\receiver.php';
require_once 'C:\xampp\htdocs\MVC\src\models\user.php';
require_once 'C:\xampp\htdocs\MVC\resources\php\apitool.php';


class MessageController {

    private $userSession;

    public function __construct() {
        $this->getUserSession();
    }

    private function getUserSession() {
        $this->userSession = Session::getInstance();
        $this->userSession->updateLastActivityTime();
    }

    public function displayMessages($resultResponse = 'none') {

        if ($this->userSession->checkIfIndexExists('current-user'))
        $currentUser = $this->userSession->getValueByIndex('current-user', true);

        $messagesList = $this->getListOfMessages($currentUser->getId());
        $galleriesList = $this->getListOfGalleries($currentUser->getId());
        
        require_once 'C:\xampp\htdocs\MVC\src\views\message.view.php';

    }

    private function getListOfMessages($userId) {

        $numberOfMessages = Message::getAllMessages($userId);
        $messagesList = array();

        if ($numberOfMessages > 0) {
            $messagesList = Message::getListOfMessages($userId);
        }

        return $messagesList;

    } 

    private function getListOfGalleries($userId) {

        $numberOfGalleries = Gallery::getAllUserGalleries($userId);
        $galleriesList = array();

        if ($numberOfGalleries > 0) {
            $galleriesList = Gallery::getListOfUserGalleries($userId);
        }

        return $galleriesList;

    } 

    public function handleMessageRequest() {

        if ($this->userSession->checkIfIndexExists('current-user'))
        $currentUser = $this->userSession->getValueByIndex('current-user', true);

        if (isset($_GET['galleriesList'])) $galleriesIds = $_GET['galleriesList'];
        if (isset($_GET['message-body'])) $messageBody = $_GET['message-body'];

        $validation = true;

        if (empty($galleriesIds) || empty($messageBody)) $validation = false;

        if ($validation) {

            $userGalleries = Gallery::getListOfUserGalleries($currentUser->getId());
            $selectedGalleries = array();

            foreach($userGalleries as $currentGallery) {
                
                foreach ($galleriesIds as $currentGalleryId) {

                    if ($currentGalleryId == $currentGallery->getId()) {

                        $gallerySelected = [
                            "id" => $currentGallery->getId(),
                            "name" => $currentGallery->getName(),
                            "region" => $currentGallery->getRegion(),
                            "email" => $currentGallery->getEmail(),
                            "site" => $currentGallery->getSite(),
                        ];

                        $selectedGalleries[] = $gallerySelected;

                    }

                }

            }

            $picturesList = Picture::getAllPicturesThroughId($currentUser->getId());
            $userPictures = array();

            while ($row = $picturesList->fetchObject()) {

                $currentPicture = [
                    "id" => $row->idObr,
                    "name" => $row->nomObr,
                    "date" => $row->fecObr,
                    "description" => $row->desObr,
                    "image" => $row->imgObr,
                    "userId" => $row->idUsu
                ];

                array_push($userPictures, $currentPicture);

            }

            $res = [
                'result' => true,
                'messageBody' => $messageBody,
                'receivers' => $selectedGalleries,
                'pictures' => $userPictures
            ];

            echo json_encode($res);
            
        } else {

            $res['result'] = false;
            echo json_encode($res);

        }

    }

    public function executeMessageRequest() {

        if ($this->userSession->checkIfIndexExists('current-user'))
        $currentUser = $this->userSession->getValueByIndex('current-user', true);

        $messageBody = '';
        $receiversList = array();
        $picturesList = array();

        // Inserting the receivers 
        if (isset($_GET['receivers'])) {

            foreach($_GET['receivers'] as $stdArray) {

                foreach (json_decode($stdArray) as $currentReceiver) {

                    $receiverObject = new Receiver(
                        null,
                        $currentReceiver->email,
                        $currentReceiver->name
                    );

                    if ($this->checkIfReceiverIsStored($receiverObject->getName())) {

                        $receiverObject->insert();                        

                    }
                    
                    array_push($receiversList, $receiverObject);
                    
                }

            }

        }

        // Inserting the message
        if (isset($_GET['message-content'])) $messageBody = $_GET['message-content']; 

        $currentMessage = new Message(
            null,
            $currentUser->getId(),
            null,
            null,
            $messageBody,
            null
        );

        $currentMessage->insert();

        // Inserting intermediate table (need last message inserted id and last receivers id's)
        $messageId = $this->getMessageId();
        $receiversIds = $this->getReceiversIds($receiversList);
        Message::insertMessageAndReceiver($messageId, $receiversIds);

        // Storing pictures

        if (isset($_GET['pictures'])) {

            foreach($_GET['pictures'] as $stdArray) {

                foreach(json_decode($stdArray) as $currentPicture) {

                    array_push($picturesList, $currentPicture);

                }
                
            }

        }

        // SMTP Mail Sending Process

        $details = [
            "pictures" => $picturesList,
            "message" => $messageBody
        ];

        foreach ($receiversList as $currentReceiver) {

            $this->sendEmailThroughSMTP($details, $currentReceiver);

        }

        $resultResponse = 'message-sent';
        $this->displayMessages($resultResponse);

    }

    private function getMessageId() {

        return Message::getMessageId();

    }

    private function getReceiversIds($receiversList) {

        return Receiver::getReceiversIds($receiversList);

    }

    private function checkIfReceiverIsStored($newName) {

        $receiversList = Receiver::getAllReceivers();

        foreach ($receiversList as $currentReceiver) {
            if ($currentReceiver->getName() == $newName) {
                return false;
            }
        }
        return true;
    }

    private function sendEmailThroughSMTP($details, $receiver) {

        $email = 'receivermail@gmail.com'; // Supposed to be $receiver->getEmail()
        $name = $receiver->getName();
        $body = $details['message'];
    
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
    
        $mail->Username = "yourmail@gmail.com"; // Your email 
        $mail->Password = "yourpass";
        
        $mail->setFrom('yourmail@gmail.com', "Hello $name");
        $mail->addReplyTo('yourmail@gmail.com', "Hello $name");
        $mail->addAddress($email, $name);
        $mail->Subject = 'Purpose of contact';
        $this->writeHTMLMessage($body);
        $mail->msgHTML(file_get_contents('resources/html/contents.html'), __DIR__);
        $mail->AltBody = 'This is a plain-text message body';

        $picturesSelected = $details['pictures'];
    
        if (!empty($picturesSelected)) {
    
            foreach($picturesSelected as $currentPicture) {
                $mail->addAttachment($currentPicture->image);
            }
            
        }

        $mail->send();

        /*
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
        */

    }

    private function writeHTMLMessage($messageBody) {

        $path = 'resources/html/contents.html';
        $HTMLCode = '';
        $HTMLCode.= 
    
<<<EX
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Content</title>
    </head>
    <body>
    
        <p>{$messageBody}</p>
    
        
    </body>
    </html>
    
EX;
    
        file_put_contents($path, $HTMLCode);
    
    }
    

}
