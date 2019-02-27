<?php 

require_once 'C:\xampp\htdocs\MVC\src\models\show.php';
require_once 'C:\xampp\htdocs\MVC\src\models\user.php';
require_once 'C:\xampp\htdocs\MVC\resources\php\apitool.php';

class ShowController {

    private $userSession;

    public function __construct() {
        $this->getUserSession();
    }

    private function getUserSession() {
        $this->userSession = Session::getInstance();
        $this->userSession->updateLastActivityTime();
    }

    public function display() {

        $at = new ApiTool();
        $res = $at->getShowsThroughOffset(1, rand(1, 500));
        $imgData = $at->getShowImage($res[0]['id']);

        if (!empty($res)) {

            $currentShow = new Show(
                $res[0]['id'],
                strtok($res[0]['created_at'], 'T'),
                strtok($res[0]['end_at'], 'T'),
                $res[0]['name'],
                !empty( $res[0]['description']) ? $res[0]['description'] : 'Description not available',
                $this->fixHeightAndWidth($imgData)
            );

        }

        require_once 'C:\xampp\htdocs\MVC\src\views\show.view.php';
        
    }

    private function fixHeightAndWidth(&$imgData) {

        $height = $imgData['height'];
        $width = $imgData['width'];
    
        if ($height > 450 || $height < 300) $height = 450;
        if ($width > 720 || $width < 450) $width = 720;
    
        $imgData['height'] = $height;
        $imgData['width'] = $width;
    
        return $imgData;
    
    }

    public function getAllShows() {

        $numberOfShows = Show::getAllShows();
        echo $numberOfShows;

    }

    public function getNextSliderImage() {

        if ($this->userSession->checkIfIndexExists('current-user'))
        $currentUser = $this->userSession->getValueByIndex('current-user', true);

        $numberOfRows = Show::getAllShows();
    
        $position = '';
        if (isset($_GET['position'])) $position = $_GET['position'];
        $nextPosition = $position + 1;
    
        if ($numberOfRows < 25) {
    
            if ($nextPosition <= $numberOfRows) {
                
                $res = Show::getShowByOrder($nextPosition);    
                echo json_encode($res);
                
            } else {
        
                    $at = new apiTool();
                    $currentShow = $at->getShowsThroughOffset(1, rand(1, 500));
                
                    $imgData = $at->getShowImage($currentShow[0]['id']);
                    
                    $showData = [
                        "id" => $currentShow[0]['id'],
                        "startingDate" => strtok($currentShow[0]['created_at'], 'T'),
                        "endingDate" => strtok($currentShow[0]['end_at'], 'T'),
                        "name" => $currentShow[0]['name'],
                        "description" => !empty($currentShow[0]['description']) ? $currentShow[0]['description'] : 'Description not available',
                        "imgData" => $imgData
                    ];
                    
                    $res = [
                        "error" => false,
                        "showData" => $showData
                    ] ;
                    
                    if (!isset($currentShow) || empty($imgData)):
                        $res["error"] = true ;
                    endif ;
                
                    $currentShow = new Show(
                        $currentShow[0]['id'],
                        strtok($currentShow[0]['created_at'], 'T'),
                        strtok($currentShow[0]['end_at'], 'T'),
                        $currentShow[0]['name'],
                        !empty($currentShow[0]['description']) ? $currentShow[0]['description'] : 'Description not available',
                        $imgData
                    );

                    $currentShow->insert($nextPosition, $currentUser->getId());
                    $currentShow->insertImage();
                
                    if ($nextPosition == 25) $res['newPosition'] = 1; else $res['newPosition'] = $nextPosition;
                
                    echo json_encode($res) ;
                
            }
    
        } else {

            if ($nextPosition > 25) $nextPosition = 1;
    
            $res = Show::getShowByOrder($nextPosition);    
            echo json_encode($res);
    
        }

    }

    public function getPreviousSliderImage() {

        $numberOfRows = Show::getAllShows();
    
        $position = '';
        if (isset($_GET['position'])) $position = $_GET['position'] - 1;
    
        if ($numberOfRows > 0) {
    
            if ($position > 0) {
    
                $res = Show::getShowByOrder($position);    
                echo json_encode($res);
            } 
            else {
    
                $position = $numberOfRows;
                
                $res = Show::getShowByOrder($position);    
                echo json_encode($res);
        
            }
    
        }
        else {
            
            $res = [
                "error" => true,
                "newPosition" => $position
            ] ;
    
            echo json_encode($res);
    
        }
    
    }

}

?>