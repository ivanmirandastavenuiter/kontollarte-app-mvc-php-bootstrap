<?php 

    require_once 'C:\xampp\htdocs\MVC\resources\php\session.php';
    
    $userSession = Session::getInstance();
    $userSession->launch();
    
    if ($userSession->allowAccess()
            && $userSession->checkIfIndexExists('current-user')) {
        $mod = $_GET['mod']??'show';
        $op = $_GET['op']??'display';
    } else {
        $mod = $_GET['mod']??'user';
        $op = $_GET['op']??'login';
    }

    if (isset($_POST['mod'], $_POST['op'])) {
        $mod = $_POST['mod'];
        $op = $_POST['op'];
    }

    $controllerName =  $mod.'Controller';

    require_once 'src/controllers/'.$controllerName.'.php';

    $controller = new $controllerName();
    if (method_exists($controller, $op)) $controller->$op();

?>

