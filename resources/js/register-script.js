$(document).ready(function() {

    var result = $('.result-response').attr('data-result-response');

    switch(result) {
        case 'user-success':
            $('#register-success').modal('show')
            break;
        case 'user-exists':
            $('#r-user-exists').modal('show')
            break;
        case 'empty-parameters':
            $('#register-error').modal('show')
            break;
        }

})

function resetValues() {
    document.getElementById("flag").value = "true" ;
    document.getElementById("register").submit() ;
}