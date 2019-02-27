$(document).ready(function() {

    $('#main-wrapper').attr('data-loaded-images', $('.col-12 > img').length);

    var totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));
    var imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));

    if ((totalImages - imagesLoaded) > 0) {
        $('#btn-container').show();
    } else {
        $('#btn-container').hide();
    }

    $('#upload-success').on('hide.bs.modal', function (e) {
        $('#upload-picture').modal('hide')
    })
    
});
