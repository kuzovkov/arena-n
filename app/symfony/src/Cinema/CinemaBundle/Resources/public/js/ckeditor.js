if ( $('textarea').is('#{{admin.uniqid}}_content') )
{
    CKEDITOR.replace('{{admin.uniqid}}_content',{width: 480, height: 400} );    
}
else if ( $('textarea').is('#{{admin.uniqid}}_description') )
{
    CKEDITOR.replace('{{admin.uniqid}}_description',{width: 480, height: 400} );
}