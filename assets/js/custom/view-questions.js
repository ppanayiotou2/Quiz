$('#q-tags-edit').select2();

var tagsHashTable = {};
$.ajax({
    url: "https://ppanayiotou2.com/quizapi/public/api/questions",
    method: "GET",
    dataType: "json",
    cache: false,
    success: function (data) {
        var questions = JSON.parse(JSON.stringify(data));

        var id,
            name,
            body,
            category,
            difficulty,
            level,
            question;



        $.ajax({
            url: "https://ppanayiotou2.com/quizapi/public/api/questions/tags/",
            method: "GET",
            dataType: "json",
            cache: false,
            success: function (data) {
                var tags = JSON.parse(JSON.stringify(data));

                for (var i = 0; i < tags.length; i++) {
                    tagsHashTable[tags[i].tag] = tags[i].question_id;
                }

            },
            error: function (jqXHR) {
                var error = JSON.parse(jqXHR.responseText);
                var errorDescription = error.description;
                console.log(errorDescription);
                //console.clear();
            }
        });

        $.each(questions, function (i, value) {

            id = questions[i].id;
            name = questions[i].name;
            body = questions[i].body;
            category = questions[i].category;
            category = category.charAt(0).toUpperCase() + category.slice(1); // Capitalize 
            difficulty = questions[i].difficulty;
            difficulty = difficulty.charAt(0).toUpperCase() + difficulty.slice(1);
            level = questions[i].level;

            if (level == "ps1") {
                level = "1st Class of Primary School";
            } else if (level == "ps3") {
                level = "3rd Class of Primary School";
            } else if (level == "ps6") {
                level = "6th Class of Primary School";
            } else if (level == "ss2") {
                level = "2nd Class of Secondary School";
            } else if (level == "l2") {
                level = "2nd Class of Lyceum";
            } else {
                level = "3rd Class of Lyceum";
            }

            question = '<tr>' +
                '<td class="q-id">' +
                id +
                '</td>' +
                '<td>' +
                name +
                '</td>' +
                '<td>' +
                difficulty +
                '</td>' +
                '<td>' +
                level +
                '</td>' +
                '<td>' +
                '<span data-toggle="tooltip" title="" data-original-title="Preview">' +
                '<i class="icon-eye table-icon view-question"></i>' +
                '</span>' +
                '<span data-toggle="tooltip" title="" data-original-title="Edit">' +
                '<i class="icon-note table-icon mid edit-question"></i>' +
                '</span>' +
                '<span data-toggle="tooltip" title="" data-original-title="Delete">' +
                '<i class="icon-trash table-icon delete-question" data-feather="trash"></i>' +
                '</span>' +
                '</td>' +
                '</tr>';

            $('.target').append(question);



        });

        $('#view-questions-table').DataTable({
            drawCallback: function () {
                // Reinitialize popovers
            }
        });


        $('.card-body.fake').hide();

        $('.card-body.hidden').fadeIn('slow');
    },
    error: function (jqXHR) {
        var error = JSON.parse(jqXHR.responseText);
        var errorDescription = error.description;
        console.log(errorDescription);
        //console.clear();
    }
});

$(document).on('click', '.delete-question', function () {
    var deletedQuestionId = $(this).parent().parent().siblings('.q-id').text();
    var deletedQuestionPlaceholder = $(this).parent().parent().parent();

    Swal.fire({
        title: 'Are you sure you want to delete this question?',
        text: "You will be able to revert this action later.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#b4b4b4',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "https://ppanayiotou2.com/quizapi/public/api/questions/" + deletedQuestionId + "",
                "method": "DELETE",
                cache: false,
                success: function (data) {
                    deletedQuestionPlaceholder.remove().fadeOut();

                    Swal.fire(
                        'Deleted!',
                        'The question has been deleted.',
                        'success'
                    )

                },
                error: function (jqXHR) {
                    var error = JSON.parse(jqXHR.responseText);
                    var errorDescription = error.description;
                    console.log(errorDescription);
                    //console.clear();
                }
            });

        }
    })
});

$(document).on('click', '.view-question', function () {
    var selectedQuestionId = $(this).parent().parent().siblings('.q-id').text();

    $.ajax({
        url: "https://ppanayiotou2.com/quizapi/public/api/questions/" + selectedQuestionId + "",
        method: "GET",
        cache: false,
        dataType: "json",
        success: function (data) {
            var question = JSON.parse(JSON.stringify(data[0]));

            var name = question.name;
            var body = question.body;

            $('#view-question-modal .quiz-card .question-name').empty().append(name);
            $('#view-question-modal .quiz-card .question-body').empty().append(body);

            $('#view-question-modal').modal('show');

            if (typeof MathJax !== 'undefined') {
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
            }

        },
        error: function (jqXHR) {
            var error = JSON.parse(jqXHR.responseText);
            var errorDescription = error.description;
            console.log(errorDescription);
            //console.clear();
        }
    });
});

$(document).on('click', '.edit-question', function () {
    var selectedQuestionId = $(this).parent().parent().siblings('.q-id').text();

    $.ajax({
        url: "https://ppanayiotou2.com/quizapi/public/api/questions/full/" + selectedQuestionId + "",
        method: "GET",
        cache: false,
        dataType: "json",
        beforeSend: function () {
            if (!CKEDITOR.instances['q_body_edit']) {
                CKEDITOR.replace('q_body_edit', {
                    cloudServices_tokenUrl: 'https://ppanayiotou2.com/Editor/create-question.php',
                    cloudServices_uploadUrl: 'https://ppanayiotou2.com/Editor/create-question.php'
                });
            }

        },
        success: function (data) {
            var question = JSON.parse(JSON.stringify(data[0]));

            var name = question.name;
            var body = question.body;
            var answerOne = question.answer_one;
            var answerTwo = question.answer_two;
            var answerThree = question.answer_three;
            var answerFour = question.answer_four;
            var level = question.level;
            var difficulty = question.difficulty;
            var category = question.category;

            $('#q-id-edit').val(selectedQuestionId);
            $('#q-name-edit').val(name);

            CKEDITOR.instances.q_body_edit.setData(body);
            $('#q-answer-one-edit').val(answerOne);
            $('#q-answer-two-edit').val(answerTwo);
            $('#q-answer-three-edit').val(answerThree);
            $('#q-answer-four-edit').val(answerFour);
            $('#q-difficulty-edit').val(difficulty);
            $('#q-level-edit').val(level);
            $('#q-category-edit').val(category);

            $('#edit-question-modal').modal('show');

            $("#q-tags-edit > option").each(function () {
                $(this).prop("selected", false);
            });

            $.ajax({
                url: "https://ppanayiotou2.com/quizapi/public/api/questions/tags/" + selectedQuestionId + "",
                method: "GET",
                dataType: "json",
                cache: false,
                success: function (data) {
                    var tags = JSON.parse(JSON.stringify(data));
                    $(tags).each(function (i) {
                        $("#q-tags-edit > option").each(function () {
                            if ($(this).val() == tags[i].tag) {
                                $(this).prop("selected", true);
                            }
                        });
                    });
                    $('#q-tags-edit').select2();
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
});


$('#edit-question-form').submit(function () {
    $('.update-question').attr("disabled", "disabled").text("UPDATING...");
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
