<?php 

require('../entities/apitool.php');
require('../entities/show.php');

// Shows extraction method
function getAllShows() {

	$at = new ApiTool();
	$shows_array = array();
	$shows_request = $at->getShows(12); 
	
    foreach ($shows_request as $show) {
        
		$currentShow = new Show();
		$currentShow->__set('id', $show['id']);
		$img_link = getImageUrl($at, $currentShow);
			
		if (!empty(getImageExt($img_link))) {
			file_put_contents('../utils/images/'.$currentShow->id.getImageExt($img_link), file_get_contents($img_link));
			$local_img = '../utils/images/'.$currentShow->id.getImageExt($img_link);
		}
			
		$currentShow->__set('startingDate', $show['created_at']);
		$currentShow->__set('endingDate', $show['end_at']);
		$currentShow->__set('name', $show['name']);
		$currentShow->__set('description', $show['description']);
		$currentShow->__set('imgUrl', $local_img);
		
		array_push($shows_array, $currentShow);
		unset($currentShow);
	}
    
    return $shows_array;
}

// Obtaining image file extension method
function getImageExt($img_url) {

	$ext_array = array(".BMP", ".EMF", ".EXIF", ".GIF", ".ICON", ".JPEG", ".JPG", ".MEMORYBMP", ".PNG", ".TIFF", ".WMF", ".JPE");
	$match = '';

	foreach ($ext_array as $ext) {
		if (preg_match("/$ext"."$/", strtoupper($img_url))) {
			$match = strtolower($ext);
		}
	}
	return $match;
}

// Obtaining image reference method 
function getImageUrl($at, $currentShow) {
	$img_link = '';
	$img_link = !empty($at->getShowImage($currentShow->id)) ? $at->getShowImage($currentShow->id) : 'https://dummyimage.com/600x400/000/fff.png&text=Currently+not+available';
	return $img_link;
}

// Random shows method
function updateShows($shows_info, $info_displayed) {

	$info_displayed = array();
	$shows_added = 0;
	while ($shows_added < 4): 
		$random = rand(0, 11);
		if (!in_array($shows_info[$random], $info_displayed)) {
			array_push($info_displayed, $shows_info[$random]);
			$shows_added++;
		}
	endwhile;
	return $info_displayed;
}


?>