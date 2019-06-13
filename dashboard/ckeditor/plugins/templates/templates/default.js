/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

// Register a templates definition set named "default".
CKEDITOR.addTemplates('default', {
    // The name of sub folder which hold the shortcut preview images of the
    // templates.
    imagesPath: CKEDITOR.getUrl(CKEDITOR.plugins.getPath('templates') + 'templates/images/'),

    // The templates definitions.
    templates: [{

            title: 'Question Template',
            image: 'template3.gif',
            description: 'Basic quiz question template with 4 questions',
            html: '<form action="includes/check_answer.php" method="post">' +
                '<p>a) 1+1=' +
                '<input class="small-input numeric-input" name="a" required="required" type="text" />' +
                '</p>' +
                '<p>b) 2+2=' +
                '<input class="small-input numeric-input" name="b" required="required" type="text" />' +
                '</p>' +
                '<p>c) 3+3=' +
                '<input class="small-input numeric-input" name="c" required="required" type="text" />' +
                '</p>' +
                '<p>d) 4+4=' +
                '<input class="small-input numeric-input" name="d" required="required" type="text" />' +
                '</p>' +
                '<p>' +
                '<input class="btn btn-primary" name="submit-answer" type="submit" value="Submit" />' +
                '</p>' +
                '</form>'

                },
        {

            title: 'Image question with 4 answers',
            image: 'capture.png',
            description: 'Basic quiz question template with 4 questions',
            html: '<div class="row">' +
                '<div class="col-lg-9">' +
                '<img alt="" class="quiz-img-resp" src="/Thesis%20Dashboard/kcfinder/upload/images/img1.png" style="width: 77%; height: 65%;" />' +
                '</div>' +
                '<div class="col-lg-3">' +
                '<form action="inc/check_answer.php" method="post">' +
                '<div class="input-wrapper">' +
                '<span class="char">a)</span>' +
                '<input class="small-input numeric-input" maxlength="1" name="a" required="required" type="text" />' +
                '</div>' +
                '<div class="input-wrapper">' +
                '<span class="char">b)</span>' +
                '<input class="small-input numeric-input" maxlength="1" name="b" required="required" type="text" />' +
                '</div>' +

                '<div class="input-wrapper">' +
                '<span class="char">c)</span> ' +
                '<input class="small-input numeric-input" maxlength="1" name="c" required="required" type="text" />' +
                '</div>' +

                '<div class="input-wrapper">' +
                '<span class="char">d)</span>' +
                '<input class="small-input numeric-input" maxlength="1" name="d" required="required" type="text" />' +
                '</div>' +
                '<input class="mybtn" name="submit-answer" type="submit" value="Submit" />' +
                '<a href="#" id="skip-btn">Skip</a></form>' +
                '</div>' +
                '</div>'
                },
        {
            title: 'Missing Number',
            image: 'template3.gif',
            description: 'Basic quiz question template with 4 questions',
            html: '<span class="missing-number dark">?</span>'
}
            ]
});
