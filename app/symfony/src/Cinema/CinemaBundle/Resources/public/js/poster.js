var IMAGE_PATH = '/bundles/cinemacinema/images/film_big/';
    var SMALL_IMAGE_PATH = '/bundles/cinemacinema/images/film/';
    
    if ( $('input').is('#{{admin.uniqid}}_poster_small') )
    {
        var inputPosterSmall = $('#{{admin.uniqid}}_poster_small');
        var value = inputPosterSmall.attr('value');
        var regEx = /\d{1,}.jpg/;
        var name = value.match(regEx);
        var image = '<p style="margin:5px"><img src="'+SMALL_IMAGE_PATH+name+'" /></p>';
        inputPosterSmall.after(image);
     
    }
    
    if ( $('input').is('#{{admin.uniqid}}_poster_big') )
    {
        var inputPosterBig = $('#{{admin.uniqid}}_poster_big');
        var value = inputPosterBig.attr('value');
        var regEx = /\d{1,}.jpg/;
        var name = value.match(regEx);
        var image = '<p style="margin:8px"><img src="'+IMAGE_PATH+name+'" width="20%" height="20%"/><p>';
        inputPosterBig.after(image);
    }