var url = window.location.href;
if (url == "https://ppanayiotou2.com/sign-in.php?register=success" || url == "https://www.ppanayiotou2.com/sign-in.php?register=success") {
    $('#login-form-ajax').find('.form-success').fadeIn().delay(5000).fadeOut();

}

$(document).on('submit', '#login-form-ajax', function (e) {
    e.preventDefault();

    var username = $(this).find('#login-username').val();
    var password = $(this).find('#login-password').val();

    $.ajax({
        "method": "POST",
        "url": "https://www.ppanayiotou2.com/quizapi/public/api/users/login",
        "async": true,
        "crossDomain": true,
        "headers": {
            "content-type": "application/json"
        },
        "processData": false,
        "data": JSON.stringify({
            "username": username,
            "password": password
        }),
        success: function (data) {
            var jsonData = JSON.parse(JSON.stringify(data[0]));
            $.ajax({
                url: "inc/auth_user.php",
                method: "POST",
                data: {
                    jsonData: jsonData
                },
                dataType: "text",
                success: function (data) {
                    window.location.href = "index.php";
                }
            });
        },
        error: function (jqXHR) {
            var error = JSON.parse(jqXHR.responseText);
            var errorDescription = error.description;
            $('#login-form-ajax').find('.form-errors').fadeIn().empty().append(errorDescription);
            //console.clear();
        }
    });
});
