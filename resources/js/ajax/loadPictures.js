function loadPictures(id) {

    var totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));
    var imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));

    imagesToLoad = totalImages - imagesLoaded;

    if (imagesToLoad > 2) {
        imagesToLoad = 2
    }
    
    var xhttp;  
  

    if (id == "") {
        document.getElementById("main-wrapper").innerHTML = "";
        return;
    }
    
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $("#main-wrapper").append(this.responseText);
        }
    };
    
    xhttp.open("GET", "index.php?mod=picture&op=loadMorePictures&id=" + id + "&imagesLoaded=" + imagesLoaded + "&imagesToLoad=" + imagesToLoad, true);
    xhttp.send();

    if (imagesToLoad > 0 ) {
        $('#main-wrapper').attr('data-loaded-images', imagesLoaded + imagesToLoad)
    }

    imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));

    if ((totalImages - imagesLoaded) > 0) {
        $('#btn-container').show();
    } else {
        $('#btn-container').hide();
    }

}
