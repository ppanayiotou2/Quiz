var intro = introJs();
intro.setOption("doneLabel", "Personalize");
intro.setOptions({
    steps: [{
            intro: 'Welcome to the Quiz, this is a small tutorial to demonstrate the basic elements of the Quiz, enjoy!'
                }, {
            element: '.question-name',
            intro: 'This is the question name, it states what you have to do to complete the question correctly.',
            position: 'bottom'
                },
        {
            element: '.question-body',
            intro: 'This is the question description, it includes images, mathematical expressions or just text, to help you answer the question.',
            position: 'bottom'
                }, {
            element: '#countdown',
            intro: 'This is the question timer. When the countdown gets to 0, you get 0 points for this question and a new question appears! Answer the question before the time is over or skip the question if you are not sure about your answer!',
            position: 'left'
                }, {
            element: '#microphone',
            intro: 'By clicking the microphone you can answer the question with your voice!',
            position: 'top'
                },
        {
            element: '#help button',
            intro: 'Hover over the help icon to see all the available commands recognizable by the Quiz!',
            position: 'top'
                },
        {
            element: '#font-btns',
            intro: 'In case the text size is too small or too big, you can change it by clicking these buttons.',
            position: 'top'
                }, {
            intro: 'We are done! Whenever you are ready, lets personalize your Quiz. Have fun!'
                },
            ]
});
intro.start();

var url = "quiz-options.php";
intro.oncomplete(function () {
    window.location.href = url;

});

intro.onexit(function () {
    window.location.href = url;
});
