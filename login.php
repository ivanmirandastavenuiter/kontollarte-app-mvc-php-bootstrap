<?php 

	session_start();

	if (isset($_GET['username']) && isset($_GET['pwd'])):

		$message = '';
	
		$username = $_GET['username']??'';
		$password = $_GET['pwd']??'';

		try {
			$lnk = new PDO("mysql:host=localhost;dbname=kontollarte", "root", "");
		} catch (PDOException $e) {
			echo "Connection failed.</br>";
			die("ERROR: ".$e->getMessage());
		}

		$sqlp = $lnk->prepare("SELECT * FROM usuario 
							   WHERE aliUsu=:username AND pasUsu=MD5(:password) ;") ;
		$sqlp->bindParam(":username",$username,PDO::PARAM_STR,50) ;
		$sqlp->bindParam(":password",$password,PDO::PARAM_STR,50) ;

		if ($sqlp->execute()):
			if ($sqlp->rowCount() > 0):
				
				$usuario = $sqlp->fetchObject() ;

				$_SESSION["idUsu"] = $usuario->idUsu;
				$_SESSION["aliUsu"] = $usuario->aliUsu;
				$_SESSION["nomUsu"] = $usuario->nomUsu;
				$_SESSION["apeUsu"] = $usuario->apeUsu;
				$_SESSION["emaUsu"] = $usuario->emaUsu;
				$_SESSION["telUsu"] = $usuario->telUsu;


				header('Location: content/index.php');

			else:

				$message = "<script>$('#wrong-credentials').modal('show')</script>";
				
			endif ;

		else:

			$message = "<script>$('#conn-error').modal('show')</script>";

		endif ;

		// Cerramos la conexión
		$lnk = null ;

	endif ;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<title>Login</title>
	<style>
		#login-container {
			width: 500px;
			margin: 0 auto;
			margin-top: 100px;
		}
		#login-container h1 {
			text-align: center;
		}
	</style>
</head>
<body>


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
			<input type="submit" value="Login" class="btn btn-primary" />
			<a href="register.php" role="button" class="btn btn-link">Create new account</a>
		</form>
		</div>

		<?php 
			require 'libs/messages.php';
			if (!empty($message)) echo $message;
		?>

</body>
</html>