$(document).ready(function (e) {

    $("#upload-picture-form").on('submit',(function(e) {
        e.preventDefault();

        uploadSuccess = false;

        $.ajax({
                url: "index.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                        cache: false,
                processData:false,
                beforeSend : function() {
                    $("#preview").fadeOut();
                    $("#err").fadeOut();
                },
                success: function(data) {

                    var imgData = JSON.parse(data).imgTag;
                    var resultResponse = JSON.parse(data).resultResponse;

                    console.log(imgData, resultResponse);

                    if (imgData != '') {
                        $("#preview").html(imgData).fadeIn();
                    }

                    switch(resultResponse) {
                        case 'forbidden-type':
                            $('#forbidden-type').modal('show');
                          break;
                        case 'upload-success':
                            uploadSuccess = true;
                            $('#upload-success').modal('show');
                          break;
                        case 'upload-exists':
                            $('#upload-exists').modal('show'); 
                          break;
                        case 'forbidden-size':
                            $('#forbidden-size').modal('show');
                          break;
                        case 'forbidden-extension':
                            $('#forbidden-extension').modal('show');
                          break;
                        case 'empty-parameters':
                            $('#empty-parameters').modal('show');
                          break;
                      }

                    var totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));
                    var imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));
                    imagesToLoad = totalImages - imagesLoaded;

                    $("#upload-picture-form")[0].reset(); 

                    $.ajax({
                        method  : "GET",
                        url     : "index.php",
                        contentType: 'html',
                        data: { "mod" : "picture", 
                                "op" : "reloadPictures",
                                "imagesToLoad" : imagesToLoad,
                                "imagesLoaded" : imagesLoaded },
                        success : function(data) {

                            if (uploadSuccess) {

                                $('#main-wrapper')[0].innerHTML += data;

                                var totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));
                                var imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));
    
                                $('#main-wrapper').attr('data-total-images', parseFloat(totalImages) + 1);
                                $('#main-wrapper').attr('data-loaded-images', parseFloat(imagesLoaded) + 1);
    
                                totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));  
                                imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));  

                                $('#painting-notfound-title').attr('style', 'display: none'); 
    
                                console.log('Computed value in recursive ajax for: ')
                                console.log('Images loaded: ' + imagesLoaded)
                                console.log('Total images: ' + totalImages)

                            }

                        },
                        error : function(e) {
                            $("#err").html(e).fadeIn();
                        }
                    });
                },
                error: function(e) {
                    $("#err").html(e).fadeIn();
                }                     
        });
    }));
});