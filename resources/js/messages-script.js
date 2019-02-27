$(document).ready(function() {

    var result = $('.result-response').attr('data-result-response');

    switch(result) {
        case 'message-sent':
            $('#message-sent').modal('show')
            break;

    }

})

$(document).ready(function() {

    $('.submit-btn').click(function()  {

        var messageBody = $('#message-body')[0].value;
        var galleriesSelected = [];

        $('.custom-control-input').each(function() {
            if (this.checked) {
                galleriesSelected.push(this.value);
            }
        })

        $.ajax({
        method  : "GET",
        url     : "index.php",
        dataType: "json",
        data: { "mod" : "message", "op" : "handleMessageRequest", "message-body" : messageBody, "galleriesList" : galleriesSelected },
        success : function(data) {  

            if(data.result) {

                $('#confirm-message .modal-body .message-content')[0].innerHTML = '';
                $('#confirm-message .modal-body .receivers-content ul').children().remove();
                $('#confirm-message .modal-body .jobs-content').children().remove();

                $('#confirm-message .modal-body .message-content').append(data.messageBody);

                $.each(data.receivers, function() {
                $('#confirm-message .modal-body .receivers-content ul')
                        .append(
                            '<li>' + this.name + ' - ' + this.email + '</li>');
                });

                $.each(data.pictures, function() {
                $('#confirm-message .modal-body .jobs-content')
                        .append(
                            "<p><strong>" + this.name + "</strong></p>" + 
                            "<img src='" + this.image + "' width='450' height='400'>" +
                            "<div class='custom-control custom-checkbox'>" 
                                + "<input type='checkbox' data-paint-id='" + this.id + "' class='custom-control-input usr-pics' id='paint" + this.id + "'>"
                                + "<label class='custom-control-label' for='paint" + this.id + "'>Include this job</label>"
                            + "</div>");
                });

                $('#message-form').submit(function(e) {

                    e.preventDefault();

                    var selectedPictures = [];
                    $('.custom-control-input.usr-pics').each(function() {
                        if (this.checked) {
                            inputData = this;
                            $.each(data.pictures, function() { 
                                if (this.id == inputData.dataset.paintId) {
                                    selectedPictures.push(this);
                                }
                            });
                        }
                    })

                    $('input#message-content').attr('value', JSON.stringify(data.messageBody));
                    $('input#receivers').attr('value', JSON.stringify(data.receivers));
                    $('input#pictures').attr('value', JSON.stringify(selectedPictures));

                    this.submit();

                })

                $('#confirm-message').modal('show')
                

            } else {

                $('#empty-message-parameters').modal('show');

            }

        },
        error : function(jqXHR, textStatus, errorThrown) {

            console.log('Response: ' + jqXHR)
            console.log('Type of error: ' + textStatus);
            console.log('Exception: ' + errorThrown);

        }
        }) ;

    });
})

$(document).ready(function() {
    if ($('.galleries-checkbox-container')[0].children.length > 1) {
        $('.submit-btn').prop('disabled', false)
    } else {
        $('.submit-btn').prop('disabled', true)
    }
})