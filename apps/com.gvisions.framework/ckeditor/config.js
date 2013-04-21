/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function(config) {
   config.filebrowserBrowseUrl = 'kcfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = './kcfinder/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = 'kcfinder/browse.php?type=flash';
   config.filebrowserUploadUrl = 'kcfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = 'kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = './kcfinder/upload.php?type=flash';
   
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


