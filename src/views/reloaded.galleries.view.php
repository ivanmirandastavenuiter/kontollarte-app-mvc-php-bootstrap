<?php 

    if (isset($galleriesList)) {

        ?>
        
        <!-- Row -->
        <div class="row">

        <?php

        $actualList = $this->userSession->getValueByIndex('actualGalleriesList', true);

        foreach($galleriesList as $key => $currentGallery) { 
            
            array_push($actualList, $currentGallery);

            ?>

                <!-- Flex container -->
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 left">
                
                    <!-- Card -->
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

            $this->userSession->setNewValue('actualGalleriesList', $actualList, true);

        } 
        
        ?>

                </div> <!-- Row end -->






















