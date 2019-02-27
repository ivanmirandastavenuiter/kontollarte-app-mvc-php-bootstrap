<?php foreach($reloadPictures as $currentPicture) { ?>

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

<?php } ?>
