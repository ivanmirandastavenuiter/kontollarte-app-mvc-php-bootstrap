<?php 

require_once 'C:\xampp\htdocs\MVC\src\models\picture.php';
require_once 'C:\xampp\htdocs\MVC\src\models\user.php';

class PictureController {

    private $userSession;

    public function __construct() {
        $this->getUserSession();
    }

    private function getUserSession() {
        $this->userSession = Session::getInstance();
        $this->userSession->updateLastActivityTime();
    }

    public function displayPictures() {

        if ($this->userSession->checkIfIndexExists('current-user'))
        $currentUser = $this->userSession->getValueByIndex('current-user', true);

        $result = Picture::getPicturesThroughId($currentUser->getId());
        $firstPictures = array();

        while ($row = $result->fetchObject()) {

            $currentPicture = new Picture(
                $row->idObr,
                $row->nomObr,
                $row->fecObr,
                $row->desObr,
                $row->imgObr,
                $row->idUsu
            );

            array_push($firstPictures, $currentPicture);
            $picturesStored = Picture::countAllPictures();
        }

        require_once 'C:\xampp\htdocs\MVC\src\views\picture.view.php';
        
    }

    public function loadMorePictures() {

        if (isset($_GET['imagesToLoad'])) $imagesToLoad = $_GET['imagesToLoad'];
        if (isset($_GET['imagesLoaded'])) $imagesLoaded = $_GET['imagesLoaded'];
        if (isset($_GET['id'])) $userId = $_GET['id'];

        $result = Picture::getMorePictures($userId, $imagesToLoad, $imagesLoaded);
        $loadPictures = array();

        while ($row = $result->fetchObject()) {

            $currentPicture = new Picture(
                $row->idObr,
                $row->nomObr,
                $row->fecObr,
                $row->desObr,
                $row->imgObr,
                $row->idUsu
            );

            array_push($loadPictures, $currentPicture);

        }

        require_once 'C:\xampp\htdocs\MVC\src\views\loaded.pictures.view.php';

    }

    public function uploadPicture() {

        if ($this->userSession->checkIfIndexExists('current-user'))
        $currentUser = $this->userSession->getValueByIndex('current-user', true);

        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); 
        $path = 'uploads/'; 
        
        $resultResponse = [
            "resultResponse" => '',
            'imgTag' => ''
        ];

        if (!empty($_POST)) {

            $title = $_POST['title']??'';
            $date = $_POST['date']??'';
            $description = $_POST['description']??'';

            $validation = true;

            if (empty($title) || empty($date) || empty($description) || !isset($_FILES['image'])) {
                $validation = false;
            }
                
            if ($validation) {

                $img = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
                $errorimg = $_FILES['image']['error'];
                $size = $_FILES['image']['size'];

                $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

                $final_image = rand(1000,1000000).$img;

                if ($errorimg > 0) {

                    $resultResponse['resultResponse'] = 'forbidden-type';

                } else {

                    if(in_array(strtolower($ext), $valid_extensions)) {
                
                        if ($size <= 500000) {
    
                            $path = $path.strtolower($final_image); 
            
                            if(move_uploaded_file($tmp, $path)) {
                            
                                $resultResponse['imgTag'] = "<img src='$path' width='446.04' height='300'/>";
                                
                                $newTitle = true;
    
                                $allPictures = Picture::getAllPicturesThroughId($currentUser->getId());
                    
                                while ($row = $allPictures->fetchObject()) {
                                    if ($row->nomObr == $title) {
                                        $newTitle = false;
                                    }
                                }
    
                                if ($newTitle) {
    
                                    $currentPicture = new Picture(
                                        null,
                                        $title,
                                        $date,
                                        $description,
                                        $path,
                                        $currentUser->getId()
                                    );
    
                                    $currentPicture->insert();
                                    $resultResponse['resultResponse'] = 'upload-success';
    
                                } else {
    
                                    $resultResponse['resultResponse'] = 'upload-exists';

                                }
                            }
    
                        } else {
    
                            $resultResponse['resultResponse'] = 'forbidden-size';

                        } 

                    } else {

                        $resultResponse['resultResponse'] = 'forbidden-extension';

                    } 

                } 

            } else {

                $resultResponse['resultResponse'] = 'empty-parameters';

            } 

            echo json_encode($resultResponse);

        } 
    }

    public function reloadPictures() {

        if ($this->userSession->checkIfIndexExists('current-user'))
            $currentUser = $this->userSession->getValueByIndex('current-user', true);
        if (isset($_GET['imagesToLoad'])) $imagesToLoad = $_GET['imagesToLoad']; 
        if (isset($_GET['imagesLoaded'])) $imagesLoaded = $_GET['imagesLoaded']; 

        $result = Picture::refreshPictures($currentUser->getId(), $imagesToLoad, $imagesLoaded);
        $reloadPictures = array();

        while ($row = $result->fetchObject()) {

            $currentPicture = new Picture(
                $row->idObr,
                $row->nomObr,
                $row->fecObr,
                $row->desObr,
                $row->imgObr,
                $row->idUsu
            );

            array_push($reloadPictures, $currentPicture);

        }

        require_once 'C:\xampp\htdocs\MVC\src\views\reloaded.pictures.view.php';

    }

}

?>