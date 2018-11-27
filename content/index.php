<?php

	require_once('../libs/functions.php');
	session_start();
	

	if (!empty($_SESSION)) {
		$id = $_SESSION['idUsu'];
		$alias = $_SESSION['aliUsu'];
		$name = $_SESSION['nomUsu'];
		$surname = $_SESSION['apeUsu'];
		$email = $_SESSION['emaUsu'];
		$phone = $_SESSION['telUsu'];
	}

	if (!isset($_SESSION['shows_info'])) {
		$_SESSION['shows_info'] = getAllShows();
		$shows_info = $_SESSION['shows_info'];
		$_SESSION['info_displayed'] = updateShows($shows_info, array());
		$info_displayed = $_SESSION['info_displayed'];
	} else {
		$shows_info = $_SESSION['shows_info'];
		$info_displayed = $_SESSION['info_displayed'];
		$_SESSION['info_displayed'] = updateShows($shows_info, $info_displayed);
		$info_displayed = $_SESSION['info_displayed'];
	}
	/*
	$_SESSION['info_displayed'] = updateShows($shows_info, array());
		$info_displayed = $_SESSION['info_displayed'];

	$_SESSION['info_displayed'] = updateShows($shows_info, $info_displayed);
		$info_displayed = $_SESSION['info_displayed'];
		*/
	

	

	
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

	.page-header {
		text-align:center;
		margin: 40px; 
	}
	.grid-container {
  		display: grid;
  		grid-template-columns: 430px 430px 430px;
 	 	grid-gap: 10px;
  		background-color: #000;
  		padding: 10px;
		justify-content:center;	
		
	}
	.grid-container > div {
  		background-color: white;
		height:300px;
		padding:20px;
	}
	.show-title {
		text-align:center;
	}
	.show-list {
		margin-top: 40px;
	}
	div[class^="imgitem"] {
		display: flex;
  		align-items: center;
  		justify-content: center;
	}



</style>
<body>

	<?php 
		require_once("navbar.html"); 
	?>
	
	<h2 class="page-header">Check out the latest shows upcoming</h2>
	<div class="grid-container">

	


	
	<?php

	// TODO: falta pedir la imagen, formatear las fechas, comprobar nulos.
	
	
	$image_first = false;
	$div_id = 1;
	
	foreach ($info_displayed as $current_show) {

		if(empty($current_show->description)) $current_show->description = 'Description not available.';
		

$showInfo = '';
$showInfo.=
<<<EX
		<div class="show-content">
			<h2 class="show-title">Show info</h2>
			<ul class="show-list">
				<li>Name: {$current_show->name}</li>
				<li>Start date: {$current_show->startingDate}</li>
				<li>Ending date: {$current_show->endingDate}</li>
				<li>Description: {$current_show->description}</li>
			</ul>
		</div>
EX;

			if (!$image_first) {
				echo "<div class='item'".$div_id."' style='grid-column: 1/3'; >".$showInfo."</div>";
				$div_id++;
				echo "<div class='imgitem'".$div_id."'><img src='{$current_show->imgUrl}' height='290' width='420'></div>";
				$div_id++;
				$image_first = !$image_first;
			} else {
				echo "<div class='imgitem'".$div_id."'><img src='{$current_show->imgUrl}' height='290' width='420'></div>";
				$div_id++;
				echo "<div class='item'".$div_id."' style='grid-column: 2/4'; >".$showInfo."</div>";
				$div_id++;
				$image_first = !$image_first;
			}
		
	}
	?>

	</div>
	
</body>
</html>