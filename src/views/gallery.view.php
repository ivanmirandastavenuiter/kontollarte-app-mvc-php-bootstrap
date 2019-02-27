<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="resources\css\gallery.css" class="css">
    <script type="text/javascript" src="resources\js\gallery-script.js"></script>
    <title>Gallery</title>
</head>
<body>

    <div class="result-response" data-result-response='none'></div>

    <?php 

        require_once 'C:\xampp\htdocs\MVC\resources\php\navbar.php';
        require_once 'C:\xampp\htdocs\MVC\resources\php\messages\gallery.messages.php';

        if (isset($resultResponse)) {

            echo "<script>";
            echo "$('.result-response').attr('data-result-response', '$resultResponse');";
            echo "</script>";

        }

    ?>

    <div class="container-fluid wrapper">

        <div class="col-12" id="gallery-view-title">
            <h2>Galleries</h2>
        </div>

        <div class="container-fluid table-container">

            <div class="col-12" id="gallery-table-title">
                <h3>My personal galleries</h3>
            </div>

            <?php 

                if ($this->userSession->checkIfIndexExists('current-user'))
                $currentUser = $this->userSession->getValueByIndex('current-user', true);

                $userGalleries = $currentUser->getStoredGalleries();

                if (count($userGalleries) > 0) {

            ?>

            <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Region</th>
                <th scope="col">Site</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                
                    $position = 1;
                    foreach ($userGalleries as $currentGallery) {
                
                ?>

                <tr>
                <th scope="row"><?= $position ?></th>
                <td><?= $currentGallery->getName(); ?></td>
                <td><?= $currentGallery->getRegion(); ?></td>
                <td><?= $currentGallery->getSite(); ?></td>
                <td><?= $currentGallery->getEmail(); ?></td>
                <td><a class="btn btn-danger dlt-btn" 
                            data-delete-id="<?= $currentGallery->getId(); ?>" 
                            data-toggle="modal" href="#confirm-delete-gallery-id">
                            Delete</a></td>
                </tr>

                <?php 

                    $position++;
                } 
                
                ?>

            </tbody>
            </table>

            <?php
            
                } else {
            
            ?>

            <div class="col-12" id="gallery-notfound-title">
                <h4>No galleries have been found on the database yet</h4>
            </div>

            <?php } ?>

        </div>

        <div class="container-fluid cards-container">

            <div class="col-12" id="gallery-table-title">
                <h3>Galleries catalogue</h3>
            </div>

            <div class="row">

            <?php 

                if (isset($galleriesList)) {

                    $this->userSession->setNewValue('actualGalleriesList', $galleriesList, true);

                    foreach($galleriesList as $key => $currentGallery) {

            ?>

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 left">
                
                    <div class="card text-center">
                        <div class="card-header">
                            Info
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $currentGallery->getName(); ?></h5>
                            <p class="card-text"><?= $currentGallery->getEmail(); ?></p>
                            <p class="card-text"><?= $currentGallery->getRegion(); ?></p>
                            <a data-toggle="modal" href="#confirm-add-gallery" 
                                    class="btn btn-warning add-btn" 
                                    data-gallery-id="index.php?mod=gallery&op=addGallery&galleryId=<?= $currentGallery->getId(); ?>">
                                    Add gallery</a>
                            <a href="<?= $currentGallery->getSite(); ?>" class="btn btn-danger">Go to the site</a>
                        </div>
                        <div class="card-footer text-muted">
                            Kontollarte
                        </div>
                    </div>

                </div>

                <?php

                        if ($key % 2 != 0) {
                            echo "</div>";
                            echo "<div class='row'>";
                        }
                    }
                } else {

                    $galleriesList = $this->userSession->getValueByIndex('actualGalleriesList', true);

                    foreach($galleriesList as $key => $currentGallery) {

                    ?>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 left">
                        
                            <div class="card text-center">
                                <div class="card-header">
                                    Info
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $currentGallery->getName(); ?></h5>
                                    <p class="card-text"><?= $currentGallery->getEmail(); ?></p>
                                    <p class="card-text"><?= $currentGallery->getRegion(); ?></p>
                                    <a data-toggle="modal" href="#confirm-add-gallery" 
                                    class="btn btn-warning add-btn" 
                                    data-gallery-id="index.php?mod=gallery&op=addGallery&galleryId=<?= $currentGallery->getId(); ?>">
                                            Add gallery</a>
                                    <a href="<?= $currentGallery->getSite(); ?>" class="btn btn-danger">Go to the site</a>
                                </div>
                                <div class="card-footer text-muted">
                                    Kontollarte
                                </div>
                            </div>

                        </div>

                        <?php

                                if ($key % 2 != 0) {
                                    echo "</div>";
                                    echo "<div class='row'>";
                                }
                            }

                        }
                        
                        ?>

            </div> 

        </div>

        <div class="refresh-btn-container">
            <button type="button" class="btn btn-secondary refresh-galleries-btn">I want more!!!</button>
        </div>

    </div> 

</body>
</html>