CKEDITOR.plugins.add('timestamp', {
    icons: 'timestamp',
    init: function (editor) {
        //Plugin logic goes here.
        editor.addCommand('insertTimestamp', {
            exec: function (editor) {
                var now = new Date();
                editor.insertHtml('<p><span class="math-tex">$\\frac{1}{3}$ </span></p>');
            }
        });

        editor.ui.addButton('Timestamp', {
            label: 'Insert Timestamp',
            command: 'insertTimestamp',
            toolbar: 'insert'
        });
    }
});
