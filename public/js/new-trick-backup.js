(function($) {
    $('#tags').selectize({
        maxItems: 5
    });
    $('#categories').selectize({
        maxItems: 5
    });
    var editor = ace.edit("editor-content");
    var codeEditor = $('#code-editor');
    editor.setTheme("ace/theme/github");
    editor.getSession().setMode("ace/mode/php");
    editor.getSession().setValue(codeEditor.val());

    codeEditor.closest('form').submit(function () {
        codeEditor.val(editor.getSession().getValue());
    })
})(jQuery);
