$(document).ready(function() {
    
    var lastChild = parseFloat($('.row > .col-sm-12 .card').length);

    var result = $('.result-response').attr('data-result-response');

    switch(result) {
        case 'add-gallery-success':
            $('#add-gallery-success').modal('show')
            break;
        case 'add-gallery-exists':
            $('#add-gallery-exists').modal('show')
            break;
        case 'delete-gallery-success':
            $('#delete-gallery-success').modal('show')
            break;
        }

    
    $(document).on('click', '.add-btn', function() {
        var galleryId = $(this).data('gallery-id');
        $('.modal-footer #confirm-gallery-id').attr('href', galleryId);
    });

    $(document).on('click', '.dlt-btn', function() {
        var deleteId = $(this).data('delete-id');

        $.ajax({
            method  : "GET",
            url     : "index.php",
            contentType: "json",
            data: { "mod" : "gallery", "op" : "getGalleryToDelete", "galleryId" : deleteId },
            success : function(data) {

                $('.name > p')[0].innerHTML = '';
                $('.region > p')[0].innerHTML = '';
                $('.site > p')[0].innerHTML = '';
                $('.email > p')[0].innerHTML = '';

                $('.name > p').append('<strong>Name: </strong>' + JSON.parse(data).name);
                $('.region > p').append('<strong>Region: </strong>' + JSON.parse(data).region);
                $('.site > p').append('<strong>Site: </strong>' + JSON.parse(data).site);
                $('.email > p').append('<strong>Email: </strong>' + JSON.parse(data).email);
                  
            },
            error : function(e) {
                $("#err").html(e).fadeIn();
            }
        })

        var href = "index.php?mod=gallery&op=deleteGallery&galleryId=" + deleteId;
        $('.modal-footer #confirm-delete-gallery-id').attr('href', href);


    });


    $(document).on('click', '.refresh-galleries-btn', function() {
        

        $.ajax({
            method  : "GET",
            url     : "index.php",
            contentType: "text",
            data: { "mod" : "gallery", "op" : "getFirstGalleries", "view-type" : "reloaded-galleries" },
            success : function(data) {
                $('.cards-container').append(data);
            },
            error : function(e) {
                $("#err").html(e).fadeIn();
            }
        })

    });

})