<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="resources\css\account.css" class="css">
    <link rel="stylesheet" href="resources\css\navbar.css" class="css">
    <script type="text/javascript" src="resources\js\account-script.js"></script>
    <title>Account</title>
</head>
<body>

    <div class="result-response" data-result-response='none'></div>

    <?php 

        require_once 'C:\xampp\htdocs\MVC\resources\php\messages\account.messages.php'; 
        require_once 'C:\xampp\htdocs\MVC\resources\php\functions.php';

        if (isset($resultResponse)) {

            if ($resultResponse == 'user-exists') writeErrorMessage($newUsername, $newEmail, $newRealName, 'update');

            echo "<script>";
            echo "$('.result-response').attr('data-result-response', '$resultResponse');";
            echo "</script>";

        }

        require_once 'C:\xampp\htdocs\MVC\resources\php\navbar.php';

    ?>

    <div class="row">
        <div class="col-12" id="user-info-item">
            <h2>User Info</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="table-info-item">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="labels">
                                <?php
                                    if ($this->userSession->checkIfIndexExists('current-user'))
                                    $currentUser = $this->userSession->getValueByIndex('current-user', true);
                                ?>
                                Alias: <?php echo $currentUser->getUsername() ?>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="labels">
                                Name: <?php echo $currentUser->getName(); ?>
                            </div>
                        </div>
                    </li>
                        <li class="list-group-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="labels">
                                Surname: <?php if (!empty($currentUser->getSurname())) echo $currentUser->getSurname(); else echo 'Not provided'; ?>
                            </div>
                        </div>
                    </li>
                        <li class="list-group-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="labels">
                                Email: <?php echo $currentUser->getEmail(); ?>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="labels">
                                Phone: <?php if (!empty($currentUser->getPhone())) echo $currentUser->getPhone(); else echo 'Not provided'; ?>
                            </div>
                        </div>
                    </li>  					
                </ul>
                <div class="d-flex justify-content-center align-items-center">
                    <button id="first-update-button" type="button" class="btn btn-warning" data-toggle="modal" data-target="#update-user">Update user</button>
                    <button id="first-delete-button" type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-delete">Delete account</button>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>