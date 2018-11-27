<?php 

	if (isset($_GET['flag']) && $_GET['flag'] == 'true') {
		$_GET = array();
	}

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
	<title>Register</title>
	<style>
		#login-container {
			width: 500px;
			margin: 0 auto;
			margin-top: 100px;
            margin-bottom: 100px;
		}
		#login-container h1 {
			text-align: center;
		}
	</style>
</head>
<body>
        <?php 

            if (!empty($_GET)) {
           
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

					// PDO connection

					try {
						$lnk = new PDO("mysql:host=localhost;dbname=kontollarte", "root", "");
					} catch (PDOException $e) {
						echo "Connection failed.</br>";
						die("ERROR: ".$e->getMessage());
					}

					// Check whether a user already exists

					$res = $lnk->query("SELECT * FROM usuario ; ") 
						or die("**Error: $lnk->errno : $lnk->error");

					$newEmail = true;
					$newUsername = true;
					$newRealName = true;

					while($row = $res->fetchObject()): 
						if ($row->aliUsu == $username) $newUsername = false;
						if ($row->emaUsu == $email) $newEmail = false;
						if ($row->nomUsu == $name && $row->apeUsu == $surname) $newRealName = false;
					endwhile ;

					$encrypted = md5($password);

					// New user and new email validated

					if ($newEmail && $newUsername && $newRealName) {

						// Prepare PDO object

						$sqlp = $lnk->prepare("INSERT INTO usuario (pasUsu, aliUsu, nomUsu, apeUsu, emaUsu, telUsu) VALUES
							(:pwd, :username, :name, :surname, :email, :phone)");

						// Bind PDO object

						$sqlp->bindParam(":pwd", $encrypted, PDO::PARAM_STR, 100);
						$sqlp->bindParam(":username", $username, PDO::PARAM_STR, 100);
						$sqlp->bindParam(":name", $name, PDO::PARAM_STR, 100);
						$sqlp->bindParam(":surname", $surname, PDO::PARAM_STR, 100);
						$sqlp->bindParam(":email", $email, PDO::PARAM_STR, 100);
						$sqlp->bindParam(":phone", $phone, PDO::PARAM_STR, 100);

						$query = $sqlp->execute();

						// Query success

						if ($query) {

							require('libs/messages.php');
							?>
							<script>$('#register-success').modal('show')</script>
							<?php 

						}

					} else { // New user, new email or new name not validated

						require('libs/messages.php');
						?>
						<script>$('#user-exists').modal('show')</script>
						<?php

					}

				} else { // Not all parameters provided

					require('libs/messages.php');
					?>
					<script>$('#register-error').modal('show')</script>
					<?php

				}

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
    			<input type="password" class="form-control" name="pwd" value="<?php if(!empty($encrypted)) echo $encrypted; ?>" placeholder="Password">
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
			<input type="submit" value="Register" class="btn btn-primary" />
			<a class="btn btn-secondary" href="login.php" role="button">Back to login</a>
			<input type="reset" value="Reset fields" class="btn btn-link" />
		</form>
		</div>

		<script>
			function resetValues() {
				document.getElementById("flag").value = "true" ;
				document.getElementById("register").submit() ;
			}
		</script>

</body>
</html>