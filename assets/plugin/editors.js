$(function() {
    $( 'textarea.tinymce_basic' ).ckeditor({width:'100%', height: '500px', toolbar: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-','Templates' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        { name: 'insert', items: [ 'Image', 'Table', 'Iframe' ] },
        // { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
        { name: 'links', items: [ 'Link', 'Unlink'] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
        { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
        { name: 'colors', items: [ 'TextColor', 'BGColor' ] }
    ]});
    $( 'textarea.tinymce_komentar' ).ckeditor({width:'100%', height: '150px', toolbar: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source'] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
        { name: 'insert', items: [ 'Image' ] },
        { name: 'styles', items: [ 'Format', 'Font' ] }
    ]});
});

(function(){
    // remove layerX and layerY
    var all = $.event.props,
        len = all.length,
        res = [];
    while (len--) {
      var el = all[len];
      if (el != 'layerX' && el != 'layerY') res.push(el);
    }
    $.event.props = res;
}());