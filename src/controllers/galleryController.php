<?php 

require_once 'C:\xampp\htdocs\MVC\src\models\gallery.php';
require_once 'C:\xampp\htdocs\MVC\src\models\user.php';
require_once 'C:\xampp\htdocs\MVC\resources\php\apitool.php';

class GalleryController {

    private $userSession;

    public function __construct() {
        $this->getUserSession();
    }

    private function getUserSession() {
        $this->userSession = Session::getInstance();
        $this->userSession->updateLastActivityTime();
    }

    public function getFirstGalleries() {

        if (isset($_GET['view-type'])) $viewType = $_GET['view-type'];

        $at = new ApiTool();
        $requestResult = $at->getGalleriesTrhoughOffset(6, rand(1, 500));
        $galleriesList = array();

        foreach ($requestResult as $currentResult) {

            $currentGallery = new Gallery (
                $currentResult['id'],
                !empty($currentResult['name']) ? $currentResult['name'] : 'Name not provided',
                !empty($currentResult['region']) ? $currentResult['region'] : 'Region not provided',
                !empty($currentResult['email']) ? $currentResult['email'] : 'Email not provided',
                !empty($currentResult['_links']['website']['href']) ? $currentResult['_links']['website']['href'] : 'Site not provided'
            );

            array_push($galleriesList, $currentGallery);

        }

        if ($viewType == 'first-galleries') {
            require_once 'C:\xampp\htdocs\MVC\src\views\gallery.view.php';
        } 
        else if ($viewType == 'reloaded-galleries') {
            require_once 'C:\xampp\htdocs\MVC\src\views\reloaded.galleries.view.php';
        }
        
    }

    public function addGallery() {

        if (isset($_GET['galleryId'])) $galleryId = $_GET['galleryId'];
        $selectedGallery = self::getSelectedGallery($galleryId);

        if ($this->userSession->checkIfIndexExists('current-user'))
        $currentUser = $this->userSession->getValueByIndex('current-user', true);

        if ($this->checkUserGalleriesList($selectedGallery)) {

            $selectedGallery->insert($currentUser->getId());
        
            $currentUser->setStoredGalleries($selectedGallery);
            $this->userSession->setNewValue('current-user', $currentUser, true);

            $resultResponse = 'add-gallery-success';
            require_once 'C:\xampp\htdocs\MVC\src\views\gallery.view.php';
            
        } else {
            $resultResponse = 'add-gallery-exists';
            require_once 'C:\xampp\htdocs\MVC\src\views\gallery.view.php';
        }

    }

    private static function getSelectedGallery($id) {

        $userSession = Session::getInstance();
        if ($userSession->checkIfIndexExists('actualGalleriesList'))
            $galleriesList = $userSession->getValueByIndex('actualGalleriesList', true);
        
        foreach ($galleriesList as $currentGallery) {
            if ($currentGallery->getId() == $id) {

                $selectedGallery = new Gallery(
                    $currentGallery->getId(),
                    $currentGallery->getName(),
                    $currentGallery->getRegion(),
                    $currentGallery->getEmail(),
                    $currentGallery->getSite()
                );

            }
        }
        return $selectedGallery;
    }

    private function checkUserGalleriesList($selectedGallery):bool {

        if ($this->userSession->checkIfIndexExists('current-user'))
            $currentUser = $this->userSession->getValueByIndex('current-user', true);

        foreach ($currentUser->getStoredGalleries() as $currentGallery) {
            if ($currentGallery == $selectedGallery) {
                return false;
            }
        }

        return true;
    }

    public function getGalleryToDelete() {

        if ($this->userSession->checkIfIndexExists('current-user'))
            $currentUser = $this->userSession->getValueByIndex('current-user', true);
        $galleriesList = $currentUser->getStoredGalleries();

        if (isset($_GET['galleryId'])) $galleryId = $_GET['galleryId'];

        foreach ($galleriesList as $currentGallery) {
            
            if ($currentGallery->getId() == $galleryId) {
                
                $selectedGallery = [
                    "id" => $currentGallery->getId(),
                    "name" =>$currentGallery->getName(),
                    "region" =>$currentGallery->getRegion(),
                    "email" =>$currentGallery->getEmail(),
                    "site" =>$currentGallery->getSite()
                ];

            }
        }

        echo json_encode($selectedGallery);

    }

    public function deleteGallery() {
        
        if ($this->userSession->checkIfIndexExists('current-user'))
            $currentUser = $this->userSession->getValueByIndex('current-user', true);
        $userGalleriesList = $currentUser->getStoredGalleries();

        if (isset($_GET['galleryId'])) $galleryId = $_GET['galleryId'];

        if (count($userGalleriesList) > 0) {

            foreach ($userGalleriesList as $key => $currentGallery) {
            
                if ($currentGallery->getId() == $galleryId) {
    
                    $indexToDelete = $key;
                    
                    $selectedGallery = new Gallery(
                        $currentGallery->getId(),
                        $currentGallery->getName(),
                        $currentGallery->getRegion(),
                        $currentGallery->getEmail(),
                        $currentGallery->getSite()
                    );
    
                }
            }

            $selectedGallery->delete($currentUser->getId());
            unset($userGalleriesList[$indexToDelete]);
            $currentUser->setStoredGalleries($userGalleriesList);
            $this->userSession->setNewValue('current-user', $currentUser, true);
    
            $resultResponse = 'delete-gallery-success';
            require_once 'C:\xampp\htdocs\MVC\src\views\gallery.view.php';

        }

    }

}

?>