$(document).ready(function() {
	$('.ss').sSelect({ddMaxHeight: '240px'});

	$('#jc').jcarousel().jcarouselAutoscroll({
            interval: 0,
            target: '+=1',
            autostart: false
        });
	
	$('.jcarousel-prev').click(function() {
		$('#jc').jcarousel('scroll', '-=1');
	});

	$('.jcarousel-next').click(function() {
		$('#jc').jcarousel('scroll', '+=1');
	});

    var resizeTimer;
    doNewHeight();
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(doNewHeight, 100);
    backlightActions();
});

function backlightActions()
{
    var uri = window.location.href;
    var slug = "/actions";
    if ( uri.lastIndexOf( slug ) == uri.length - slug.length ){
        var nav = document.getElementById('actions');
        nav.className = "active";
    }
}


function allowChangeHeight()
{
    var uri = window.location.href;
    whiteList = ["/retrobar/schedule"];
    blackList = ["/schedule", "/login"];
    for ( var i = 0; i < whiteList.length; i++ )
        if ( uri.lastIndexOf( whiteList[i] ) == uri.length - whiteList[i].length ) return true;
    for ( var i = 0; i < blackList.length; i++ )
        if ( uri.lastIndexOf( blackList[i] ) == uri.length - blackList[i].length ) return false;
    return true;  
}

function doNewHeight() {
    
    var colheight = $(window).height() - 270 - 236;
	var realHeight = $('.wrap-content').height();
	if ( realHeight < colheight && allowChangeHeight() )
	{
		$('.wrap-content').css('height',colheight+'px');
	}
}

var resizeTimer;
$(window).resize(function() {
    if ( allowChangeHeight() )
    {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(doNewHeight, 100);
    }
});