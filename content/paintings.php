<?php 

	session_start();

	if (!empty($_SESSION)) {
		$id = $_SESSION['idUsu'];
		$alias = $_SESSION['aliUsu'];
		$name = $_SESSION['nomUsu'];
		$surname = $_SESSION['apeUsu'];
		$email = $_SESSION['emaUsu'];
		$phone = $_SESSION['telUsu'];
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
	<link rel="stylesheet" href="../css/navbar.css" class="css">
	<link rel="stylesheet" href="../css/account.css" class="css">
	<title>Login</title>
</head>
<style>


	.grid-container {
  		display: grid;
  		grid-template-columns: auto auto auto;
  		background-color: yellow;
		  padding: 10px;
		  width: 1000px;
		  margin:0  auto;
	}
	.grid-item {
  		background-color: white;
  		border: 1px solid rgba(0, 0, 0, 0.8);
  		padding: 20px;
		text-align: center;
		height: 200px;
	}
</style>
<body>

	<?php 
		require_once("navbar.html"); 
	?>

	
	<div class="grid-container">
  		<div class="grid-item">1</div>
  		<div class="grid-item">2</div>
  		<div class="grid-item">3</div>  
  		<div class="grid-item">4</div>
  		<div class="grid-item">5</div>
  		<div class="grid-item">6</div>  
  		<div class="grid-item">7</div>
  		<div class="grid-item">8</div>
  		<div class="grid-item">9</div>  
	</div>
		
</body>
</html>