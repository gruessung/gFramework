/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function(config) {
   config.filebrowserBrowseUrl = './index.php?action=fm';
   config.filebrowserImageBrowseUrl = './index.php?action=fm';
   config.filebrowserFlashBrowseUrl = './index.php?action=fm';
   config.filebrowserUploadUrl = './index.php?action=fm';
   config.filebrowserImageUploadUrl = './index.php?action=fm';
   config.filebrowserFlashUploadUrl = './index.php?action=fm';
   
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


