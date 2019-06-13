$(document).on('submit', '#register-form-ajax', function (e) {
    e.preventDefault();

    var username = $(this).find('#register-username').val();
    var email = $(this).find('#register-email').val();
    var firstName = $(this).find('#register-first-name').val();
    var lastName = $(this).find('#register-last-name').val();
    var password = $(this).find('#register-password').val();
    var gender = $("#gender option:selected").val();


    $.ajax({
        "method": "POST",
        "url": "https://www.ppanayiotou2.com/quizapi/public/api/users",
        "async": true,
        "crossDomain": true,
        "headers": {
            "content-type": "application/json"
        },
        "processData": false,
        "data": JSON.stringify({
            "username": username,
            "password": password,
            "email": email,
            "firstName": firstName,
            "lastName": lastName,
            "gender": gender
        }),
        success: function (data) {
            window.location.href = "sign-in.php?register=success";

        },
        error: function (jqXHR) {
            var error = JSON.parse(jqXHR.responseText);
            var errorDescription = error.description;
            $('#register-form-ajax').find('.form-errors').fadeIn().empty().append(errorDescription);

            if (errorDescription.indexOf("Username") >= 0) {
                $('#register-form-ajax').find('#register-username').addClass('has-error');
            } else {
                $('#register-form-ajax').find('#register-username').removeClass('has-error');

            }

            if (errorDescription.indexOf("Email") >= 0) {
                $('#register-form-ajax').find('#register-email').addClass('has-error');
            } else {
                $('#register-form-ajax').find('#register-email').removeClass('has-error');

            }

            //console.clear();
        }
    });
});
