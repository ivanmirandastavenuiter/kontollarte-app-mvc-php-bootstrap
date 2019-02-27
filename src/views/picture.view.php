<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="resources/js/ajax/loadPictures.js"></script>
    <script src="resources/js/ajax/uploadPicture.js"></script>
    <script type="text/javascript" src="resources\js\picture-script.js"></script>
	<link rel="stylesheet" href="resources\css\paintings.css" class="css">
    <title>Paintings</title>
</head>
<body>

    <?php 
     
        require_once 'C:\xampp\htdocs\MVC\resources\php\navbar.php';
        require_once 'C:\xampp\htdocs\MVC\resources\php\messages\paintings.messages.php';

    ?>

    <div class="col-12" id="painting-title">
        <h3>My jobs</h3>
    </div>

    <div id="btn-upload-container">
        <button type="submit" id="btn-upload" data-toggle="modal" data-target="#upload-picture" type="button" class="btn btn-danger">Upload new picture</button>
    </div>

    <div id="main-wrapper" data-page="0" data-loaded-images="0 " data-total-images="0">

        <?php 

            if (isset($picturesStored)) {
                echo "<script>";
                echo "$('#main-wrapper').attr('data-total-images', '$picturesStored')";
                echo "</script>";
            }

            if (count($firstPictures) > 0) {

            foreach ($firstPictures as $currentPicture) {
        ?>

        <div class="row" id="photo-item">
            <div class="col-12">
                <img src="<?=$currentPicture->getImage()?>" height="300" width="500">
            </div>
            </div>
            <div class="row" id="description-item">
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" id="list-title-list" data-toggle="list" href="#list-title<?=$currentPicture->getId()?>" role="tab" aria-controls="title">Title</a>
                <a class="list-group-item list-group-item-action" id="list-date-list" data-toggle="list" href="#list-date<?=$currentPicture->getId()?>" role="tab" aria-controls="date">Date</a>
                <a class="list-group-item list-group-item-action" id="list-description-list" data-toggle="list" href="#list-description<?=$currentPicture->getId()?>" role="tab" aria-controls="description">Description</a>
                </div>
            </div>
            <div class="col-8">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-title<?=$currentPicture->getId()?>" role="tabpanel" aria-labelledby="list-title-list"><?=$currentPicture->getTitle()?></div>
                    <div class="tab-pane fade" id="list-date<?=$currentPicture->getId()?>" role="tabpanel" aria-labelledby="list-date-list"><?=$currentPicture->getDate()?></div>
                    <div class="tab-pane fade" id="list-description<?=$currentPicture->getId()?>" role="tabpanel" aria-labelledby="list-description-list"><?=$currentPicture->getDescription()?></div>
                </div>
            </div>
        </div>

        <?php

                }
            } else {
            
        ?>

        <div class="col-12" id="painting-notfound-title">
            <h4>No painitings have been found on the database yet</h4>
        </div>

        <?php } ?>

    </div> 

    <div id="btn-container">
        <button id="btn-load" onclick="loadPictures(this.value)" value="<?php echo $currentUser->getId(); ?>" type="button" class="btn btn-primary btn-lg btn-block">Load More</button>
    </div>

</body>
</html>