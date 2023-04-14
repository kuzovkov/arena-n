var browser = navigator.userAgent.toLowerCase();
    if ( ( browser.indexOf( 'msie' ) != -1 ) || ( 
                        browser.indexOf( 'firefox' ) != -1 ) )
    {
         if ( $('input').is('#{{admin.uniqid}}_date_first') )
        {
            $('input#{{admin.uniqid}}_date_first').datepicker( $.datepicker.regional[ "ru" ]  );
        }
        
        if ( $('input').is('#{{admin.uniqid}}_date_last') )
        {
            $('input#{{admin.uniqid}}_date_last').datepicker($.datepicker.regional[ "ru" ]);
        }
    
    }  