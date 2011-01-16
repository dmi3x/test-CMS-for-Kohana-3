/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{        
    config.toolbar = 'MyToolbar';
    config.resize_enabled = false;
    config.skin = "v2";

    config.toolbar_MyToolbar =
    [
        ['Source','-','Save','NewPage','Preview','-','Templates'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        '/',
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Link','Unlink','Anchor'],
        ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
        '/',
        ['Format','Font','FontSize'],
        ['TextColor','BGColor'],
        ['Maximize', 'ShowBlocks']
    ];

    config.toolbar_ShortToolbar =
    [
        ['Source'],
        ['Cut','Copy','Paste'],
        ['Undo','Redo'],
        ['Bold','Italic','Underline','Strike'],
        ['NumberedList','BulletedList'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Link','Unlink','Anchor'],
        ['Table','SpecialChar'],
        ['Format','Font','FontSize'],
        ['TextColor','BGColor','Maximize']
    ];
    
    config.toolbar_UploadToolbar =
    [
        ['Source'],
        ['Undo','Redo'],
        ['Link','Unlink'],
	['Image','Flash'],
    ];
};
