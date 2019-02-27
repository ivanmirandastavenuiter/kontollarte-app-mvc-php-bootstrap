<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="resources\css\login.css" class="css">
    <title>Login</title>
</head>
<body>

<?php
    
    require_once 'C:\xampp\htdocs\MVC\resources\php\messages\register.login.messages.php'; 
    
    if (isset($_GET['login-error']) && $_GET['login-error']) 
        echo "<script>$('#wrong-credentials').modal('show')</script>";
?>

	<div id="login-container">
        <form action="" method="get">
            <h1>LOGIN</h1>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="pwd">Password</label>
                <input type="password" class="form-control" name="pwd" placeholder="Password">
            </div>
                <input type="hidden" name="mod" value="user">
                <input type="hidden" name="op" value="validateLogin">
                <input type="submit" value="Login" class="btn btn-primary" />
                <a href="index.php?mod=user&op=register" role="button" class="btn btn-link">Create new account</a>
        </form>
    </div>
</body>
</html>