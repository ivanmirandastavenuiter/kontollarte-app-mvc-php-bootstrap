<?php 

require_once 'C:\xampp\htdocs\MVC\src\models\user.php';
require_once 'C:\xampp\htdocs\MVC\src\models\gallery.php';

class UserController {

    private $userSession;

    public function __construct() {
        $this->getUserSession();
    }

    private function getUserSession() {
        $this->userSession = Session::getInstance();
        $this->userSession->updateLastActivityTime();
    }

    public function login() {

        if ($this->userSession->checkIfIndexExists('current-user')) {
            $this->userSession->kill();
        }
        
        require_once 'C:\xampp\htdocs\MVC\src\views\user.login.view.php';
    }

    public function register() {
        require_once 'C:\xampp\htdocs\MVC\src\views\user.register.view.php';
    }

    public function validateLogin() {

        if (isset($_GET['username'], $_GET['pwd'])) {

            $username = $_GET['username'];
            $pass = $_GET['pwd'];

            $userInfo = User::getUserThroughNameAndPass($username, $pass);

            if (!empty($userInfo)) {
                
                $currentUser = new User(
                    $userInfo->idUsu,
                    $userInfo->pasUsu,
                    $userInfo->aliUsu,
                    $userInfo->nomUsu,
                    $userInfo->apeUsu,
                    $userInfo->emaUsu,
                    $userInfo->telUsu
                );

                $currentUser->setIsLogged(true);
                $currentUser->setStoredGalleries(User::getPersonalGalleries($currentUser->getId()));

                $this->userSession->setNewValue('current-user', $currentUser, true);

                header('Location: index.php?mod=show&op=display');

            } else {
                
               header('Location: index.php?login-error=true');

            }
        }
    }

    public function validateRegister() {

       if(isset($_GET['flag']) && $_GET['flag'] == 'false') { 

            $username = $_GET['username']??'';
            $password = $_GET['pwd']??'';
            $name = $_GET['name']??'';
            $surname = $_GET['surname']??'';
            $email = $_GET['email']??'';
            $phone = $_GET['phone']??'';

            $validation = true;
		
            if ((empty($username)) || (empty($password)) || (empty($name))
                || (empty($email))) {
                $validation = false;
            }

            if ($validation) {

                $newUsername = true;
                $newEmail = true;
                $newRealName = true;

                $usersList = User::getAllUsers();

                while ($row = $usersList->fetchObject()) {

                    if ($row->aliUsu == $username) {
						$newUsername = false;
					} 
					if ($row->emaUsu == $email) {
						$newEmail = false;
					}
					if ($row->nomUsu == $name && $row->apeUsu == $surname) {
						$newRealName = false;
					}

                }

                if ($newUsername && $newEmail && $newRealName) { 

                    $currentUser = new User (
                        null,
                        md5($password),
                        $username,
                        $name,
                        $surname,
                        $email,
                        $phone
                    );

                    $currentUser->insert();
                    $resultResponse = 'user-success';
                    require_once 'C:\xampp\htdocs\MVC\src\views\user.register.view.php';

                } else {

                    $currentUser = new User (
                        null,
                        md5($password),
                        $username,
                        $name,
                        $surname,
                        $email,
                        $phone
                    );

                    $resultResponse = 'user-exists';
                    require_once 'C:\xampp\htdocs\MVC\src\views\user.register.view.php';


                } 

            } else {

                $resultResponse = 'empty-parameters';
                require_once 'C:\xampp\htdocs\MVC\src\views\user.register.view.php';

            } 

        } else {

            $_GET = array();
            require_once 'C:\xampp\htdocs\MVC\src\views\user.register.view.php';

        } 

    } 

    public function displayAccount() {

        if ($this->userSession->checkIfIndexExists('current-user'))
            $currentUser = $this->userSession->getValueByIndex('current-user', true);

        require_once 'C:\xampp\htdocs\MVC\src\views\user.account.view.php';

    }

    public function validateUpdate() {

        if ($this->userSession->checkIfIndexExists('current-user'))
        $currentUser = $this->userSession->getValueByIndex('current-user', true);

        if (isset($_GET['update-form']) && $_GET['update-form'] == 'true') {

            $username = $_GET['username']??'';
            $password = $currentUser->getPass();
            $name = $_GET['name']??'';
            $surname = $_GET['surname']??'';
            $email = $_GET['email']??'';
            $phone = $_GET['phone']??'';

            $validation = true;
		
            if ((empty($username)) || (empty($password)) || (empty($name))
                || (empty($email))) {
                $validation = false;
            }

            if ($validation) { 

                $newUsername = true;
                $newEmail = true;
                $newRealName = true;

                $usersList = User::getAllUsers();

                while ($row = $usersList->fetchObject()) {

                    if ($row->idUsu != $currentUser->getId()) {

                        if ($row->aliUsu == $username) {
                            $newUsername = false;
                        } 
                        if ($row->emaUsu == $email) {
                            $newEmail = false;
                        }
                        if ($row->nomUsu == $name && $row->apeUsu == $surname) {
                            $newRealName = false;
                        }

                    }

                }

                if ($newEmail && $newUsername && $newRealName) { 

                    $userUpdated = new User (
                        $currentUser->getId(),
                        $currentUser->getPass(),
                        $username,
                        $name,
                        $surname,
                        $email,
                        $phone
                    );

                    $userUpdated->update();
                   $this->userSession->setNewValue('current-user', $userUpdated, true);

                    $resultResponse = 'update-success';
                    require_once 'C:\xampp\htdocs\MVC\src\views\user.account.view.php';

                } else {

                    $resultResponse = 'user-exists';
                    require_once 'C:\xampp\htdocs\MVC\src\views\user.account.view.php';

                } 

            } else {

                $resultResponse = 'empty-parameters';
                require_once 'C:\xampp\htdocs\MVC\src\views\user.account.view.php';

            } 

        } 

    } 

    public function validateDelete() {

        if ($this->userSession->checkIfIndexExists('current-user'))
        $currentUser = $this->userSession->getValueByIndex('current-user', true);

        $currentUser->delete();

        $resultResponse = 'delete-success';
        require_once 'C:\xampp\htdocs\MVC\src\views\user.account.view.php';

    }

}

?>