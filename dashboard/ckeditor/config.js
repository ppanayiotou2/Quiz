/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
    config.extraPlugins = 'basewidget,widget,lineutils,clipboard,dialog,dialogui,notification,toolbar,button,widgetselection,stylesheetparser,templates,mathjax,timestamp';
    config.contentsCss = ['../assets/css/dashboard.css', '../assets/css/bootstrap.min.css'];
    config.allowedContent = true;
    config.bodyClass = 'question-body-sim';

    config.filebrowserBrowseUrl = 'kcfinder/browse.php?opener=ckeditor&type=files';
    config.filebrowserImageBrowseUrl = 'kcfinder/browse.php?opener=ckeditor&type=images';
    config.filebrowserFlashBrowseUrl = 'kcfinder/browse.php?opener=ckeditor&type=flash';
    config.filebrowserUploadUrl = 'kcfinder/upload.php?opener=ckeditor&type=files';
    config.filebrowserImageUploadUrl = 'kcfinder/upload.php?opener=ckeditor&type=images';
    config.filebrowserFlashUploadUrl = 'kcfinder/upload.php?opener=ckeditor&type=flash';
    config.mathJaxLib = '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML';
    config.height = 350;
    //N1ED
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
};
