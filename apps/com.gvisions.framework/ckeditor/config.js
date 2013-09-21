/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function(config) {
   config.filebrowserBrowseUrl = './filemanager/filemanager.php';
   config.filebrowserImageBrowseUrl = './filemanager/filemanager.php';
   config.filebrowserFlashBrowseUrl = './filemanager/filemanager.php';
   config.filebrowserUploadUrl = './filemanager/filemanager.php';
   config.filebrowserImageUploadUrl = './filemanager/filemanager.php';
   config.filebrowserFlashUploadUrl = './filemanager/filemanager.php';
   
   config.contentsCss = '../../styles/bootstrap/css/bootstrap.css';
   
};

CKEDITOR.on( 'dialogDefinition', function( ev ) {

    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    if ( dialogName == 'table' )
    {

        var addCssClass = dialogDefinition.getContents('advanced').get('advCSSClasses');

        addCssClass['default'] = 'table table-striped table-bordered'

    }
});


