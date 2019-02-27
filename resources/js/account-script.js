$(document).ready(function() {

    var result = $('.result-response').attr('data-result-response');

    switch(result) {
        case 'update-success':
            $('#update-success').modal('show')
            break;
        case 'user-exists':
            $('#u-user-exists').modal('show')
            break;
        case 'empty-parameters':
            $('#register-error').modal('show')
            break;
        case 'delete-success':
            $('#delete-success').modal('show')
            break;
        }

})