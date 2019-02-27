<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="resources\css\register.css" class="css">
    <script type="text/javascript" src="resources\js\register-script.js"></script>
	<title>Register</title>
</head>
<body>

    <div class="result-response" data-result-response='none'></div>

    <?php 

        require_once 'C:\xampp\htdocs\MVC\resources\php\messages\register.login.messages.php'; 
        require_once 'C:\xampp\htdocs\MVC\resources\php\functions.php';

        if (isset($resultResponse)) {

            if ($resultResponse == 'user-exists') writeErrorMessage($newUsername, $newEmail, $newRealName, 'register');

            echo "<script>";
            echo "$('.result-response').attr('data-result-response', '$resultResponse');";
            echo "</script>";

        }

    ?>

    <div id="login-container">
        <form action="" method="get" onreset="resetValues()" id="register">
            <h1>REGISTER</h1>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" value="<?php if(!empty($username)) echo $username; ?>" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="pwd">Password</label>
                <input type="password" class="form-control" name="pwd" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="<?php if(!empty($name)) echo $name; ?>" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" class="form-control" name="surname" value="<?php if(!empty($surname)) echo $surname; ?>" placeholder="Surname">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="<?php if(!empty($email)) echo $email; ?>" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" pattern="[0-9]{9}" name="phone" value="<?php if(!empty($phone)) echo $phone; ?>" placeholder="Phone">
            </div>

            <input type="hidden" value="false" id="flag" name="flag" />
            <input type="hidden" name="mod" value="user">
            <input type="hidden" name="op" value="validateRegister"> 
            <input type="submit" value="Register" class="btn btn-primary" />
            <a class="btn btn-secondary" href="index.php?mod=user&op=login" role="button">Back to login</a>
            <input type="reset" value="Reset fields" class="btn btn-link" />
        </form>
	</div>

</body>
</html>