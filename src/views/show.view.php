<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="resources\css\show.css" class="css">
    <script type="text/javascript" src="resources\js\shows-script.js"></script>
    <title>Shows</title>
</head>
<body>

<?php 

    require_once 'C:\xampp\htdocs\MVC\resources\php\navbar.php';
    require_once 'C:\xampp\htdocs\MVC\resources\php\messages\show.messages.php';

?>

<div class="container-fluid main-container">

    <div class="col-12" id="show-view-title">
        <h2>Shows</h2>
        <h3>Check out the latest shows upcoming!</h3>
    </div>

    <div class="slider-container" data-position=0 data-database=true>

    <div class="gif-container">
    <h3>Loading...</h3>
        <div class="gif"></div>
    </div>

        <div id="carouselExampleControls" class="carousel slide" data-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" 
                     src="<?= $currentShow->getImgInfo()['link']?>" 
                     height="<?= $currentShow->getImgInfo()['height']?>" 
                     width="<?= $currentShow->getImgInfo()['width']?>"
                     alt="Slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>

    </div>

    <div class="container-fluid info-container">
        <div class="info-content-container">
            <div class="row info-row">

                <div class="col info-column">

                    <div class="card-container">
                        <div class="card-top">
                            <div class="icon-container">
                                <i class="fas fa-pencil-alt"></i>
                            </div>
                            <h3>Name</h3>
                        </div>
                        <div class="card-bottom">
                                <p class="name-paragraph">"<?= $currentShow->getName() ?>"</p>
                        </div>
                    </div>

                </div>

                <div class="col info-column">

                    <div class="card-container">
                            <div class="card-top">
                                <div class="icon-container">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <h3>Dates</h3>
                            </div>
                            <div class="card-bottom">
                            <p class="date-paragraph">
                                <b>Starting date: </b><?= $currentShow->getStartingDate(); ?></br>
                                <b>Starting date: </b><?= $currentShow->getEndingDate(); ?>
                            </p>
                            </div>
                    </div>

                </div>

                <div class="col info-column">

                <div class="card-container">
                        <div class="card-top">
                            <div class="icon-container">
                            <i class="fas fa-eye"></i>
                            </div>
                            <h3>Description</h3>
                        </div>
                        <div class="card-bottom">
                        <p class="description-paragraph">"<?= $currentShow->getDescription() ?>"</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    
    </div> 

</div> 
</body>
</html>