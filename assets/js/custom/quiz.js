var fontSize = Cookies.get('fontSize');
if (fontSize) {
    $('body').css('font-size', fontSize + "px");
}


var hasStarted = Cookies.get('hasStarted');


$('.quiz-menu').show();



$('[data-toggle="popover"]').popover();


$(document).on('click', '#inc-font', function () {
    // Increase current size by 1
    var currentSize = parseInt($('body').css('font-size')) + 1;
    if (currentSize < 20) {
        $('body').css("font-size", currentSize);
    }
    Cookies.set('fontSize', currentSize, {
        expires: 7,
        path: ''
    });

});


$(document).on('click', '#dec-font', function () {
    // Decrease current size by 1
    var currentSize = parseInt($('body').css('font-size')) - 1;

    if (currentSize > 13) {
        $('body').css("font-size", currentSize);
    }
    Cookies.set('fontSize', currentSize, {
        expires: 7,
        path: ''
    });

});




var userCurrentQuestionId = $('.quiz-card #q_id').val();
var userCurrentQuestionNumber = $('.quiz-card #q_user_num').val();
if (userCurrentQuestionNumber == 1) {
    $.ajax({
        url: "https://www.ppanayiotou2.com/quizapi/public/api/questions/ps1/easy/",
        method: "GET",
        dataType: "json",
        success: function (data) {
            var response = JSON.parse(JSON.stringify(data));


            var randomQuestionId = response[Math.floor(Math.random() * response.length)]
            randomQuestionId = randomQuestionId.id;

            $.ajax({
                url: "https://www.ppanayiotou2.com/quizapi/public/api/questions/" + randomQuestionId + "",
                method: "GET",
                dataType: "json",
                success: function (data) {
                    var response = JSON.parse(JSON.stringify(data[0]));

                    var questionId = response.id;
                    var questionName = response.name;
                    var questionDifficulty = response.difficulty;
                    var questionLevel = response.level;
                    var questionBody = response.body;


                    $('.quiz-card #q_id').val(questionId);
                    $('.quiz-card .question-name').append(questionName);
                    $('.quiz-card #difficulty').val(questionDifficulty);
                    $('.quiz-card #level').val(questionLevel);
                    $('.quiz-card .question-body').append(questionBody);

                    var seconds;

                    if (questionDifficulty == "easy") {
                        seconds = 160;
                    } else {
                        seconds = 160;
                    }

                    setCountdown(seconds);
                },
                error: function (jqXHR) {
                    var error = JSON.parse(jqXHR.responseText);
                    var errorDescription = error.description;
                    console.log(errorDescription);
                    //console.clear();
                }
            });
        },
        error: function (jqXHR) {
            var error = JSON.parse(jqXHR.responseText);
            var errorDescription = error.description;
            console.log(errorDescription);
            //console.clear();
        }
    });
} else {
    $.ajax({
        url: "https://www.ppanayiotou2.com/quizapi/public/api/questions/" + userCurrentQuestionId + "",
        method: "GET",
        dataType: "json",
        success: function (data) {
            var response = JSON.parse(JSON.stringify(data[0]));

            var questionId = response.id;
            var questionName = response.name;
            var questionDifficulty = response.difficulty;
            var questionLevel = response.level;
            var questionBody = response.body;


            $('.quiz-card #q_id').val(questionId);
            $('.quiz-card .question-name').append(questionName);
            $('.quiz-card #difficulty').val(questionDifficulty);
            $('.quiz-card #level').val(questionLevel);
            $('.quiz-card .question-body').append(questionBody);

            var seconds;

            if (questionDifficulty == "easy") {
                seconds = 80;
            } else {
                seconds = 160;
            }

            setCountdown(seconds);
        },
        error: function (jqXHR) {
            var error = JSON.parse(jqXHR.responseText);
            var errorDescription = error.description;
            console.log(errorDescription);
            //console.clear();
        }
    });
}

var performed = false;

function setCountdown(seconds) {
    if ($(window).width() > 800) {
        var countdown = $("#countdown").countdown360({
            radius: 30,
            seconds: seconds,
            strokeWidth: 4,
            fillStyle: 'rgba(211, 81, 58, 0)',
            strokeStyle: '#077e3e',
            fontSize: 30,
            label: "false",
            fontColor: '#077e3e',
            autostart: true,
            onComplete: function () {
                $('#skip-btn').trigger('click');
                performed = true;
            }
        }).start()
    } else {
        var countdown = $("#countdown").countdown360({
            radius: 22,
            seconds: seconds,
            strokeWidth: 2,
            fillStyle: 'rgba(211, 81, 58, 0)',
            strokeStyle: '#077e3e',
            fontSize: 22,
            label: "false",
            fontColor: '#077e3e',
            autostart: true,
            onComplete: function () {
                $('#skip-btn').trigger('click');
                performed = true;
            }
        }).start()
    }

}

/*Append to the submitted form the id and difficulty
of the current question since they are needed for
the selection of the next question*/

var skipped = false;

$(document).on('submit', 'form', function () {
    
     if (skipped == true){
        $('#skip-btn').val("SKIPPING...");
         skipped = false;
     }
     else{
         $('input[name=submit-answer]').val("SUBMITTING...");
     }

    var q_id = $(this).parents('.card-body').children('#q_id').val();
    var q_difficulty = $(this).parents('.card-body').children('#difficulty').val();
    var q_level = $(this).parents('.card-body').children('#level').val();

    $(this).append('<input type="hidden" name="question_id" value="' + q_id + '" />');
    $(this).append('<input type="hidden" name="question_difficulty" value="' + q_difficulty + '" />');
    $(this).append('<input type="hidden" name="question_level" value="' + q_level + '" />');
    
});


$(document).on('click', '#skip-btn', function () {
    $('input').removeAttr('required');
    skipped = true;
});

/*CKEDITOR 4 doesn't provide an input type number
so we have to manually disable chars from being
inserted in inputs with class numeric-input*/
$(document).on('keypress keyup blur', '.numeric-input', function (event) {
    $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});

$(document).on('click focus', 'input[type=text]', function () {
    var chosenInput = $(this);
    var recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition || window.mozSpeechRecognition || window.msSpeechRecognition)();
    recognition.lang = 'en-US';
    recognition.interimResults = false;
    recognition.maxAlternatives = 5;
    recognition.start();

    recognition.onresult = function (event) {
        chosenInput.val(event.results[0][0].transcript);
    };
});

$(document).on('click focus', '#microphone', function () {
    console.log($(this).children('.mic-icon').data("feather"));

    var chosenInput = $(this);
    var result;
    var recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition || window.mozSpeechRecognition || window.msSpeechRecognition)();
    recognition.lang = 'en-US';
    recognition.interimResults = false;
    recognition.maxAlternatives = 5;
    recognition.start();

    recognition.onresult = function (event) {
        result = (event.results[0][0].transcript);
        console.log(result);
        if (result == "submit") {
            $('input[name=submit-answer]').trigger('click');
        } else if (result == "skip") {
            $('#skip-btn').trigger('click');
        } else {
            var placementFrom = "bottom";
            var placementAlign = "center";
            var state = "danger";
            var content = {};

            content.message = 'The speech command <b><u>' + result + '</b></u> is not recognizable, please try again.';
            content.title = 'Unknown Command';
            content.icon = 'fas fa-microphone';

            $.notify(content, {
                type: state,
                placement: {
                    from: placementFrom,
                    align: placementAlign
                },
                time: 6500
            });
        }
    };
});
