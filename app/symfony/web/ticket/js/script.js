$(function(){

var selectedPlaces = new Array();
var MAX_PLACES = 5;

$('.place').click(function(){ 
								
								$(this).toggleClass('selected');
								var place = parseInt(this.id);
								var div = $(this).parents('.row');
								var row = parseInt(div.attr('id'));
								if ( $(this).hasClass( 'selected' ) )
								{
									addPlace( row, place );
								}
								else
								{
									delPlace( row, place );
								}
								if ( !checkMaxPlaces() )
								{
									$(this).removeClass('selected');
									delPlace( row, place );
								}
								printSelected();
							});


$('#send-selected').click( function(){
										
										var data = '{';
										for ( i = 0; i < selectedPlaces.length; i++ )
										{
											data += selectedPlaces[i][0] + ':' + selectedPlaces[i][1];
											if ( i < selectedPlaces.length - 1 ) data += ','
										}
										data += '}';
										$('#result').load('handler.php',{data:data});

									});
									
$(document).tooltip();
							
function checkMaxPlaces()
{
	return ( selectedPlaces.length <= MAX_PLACES )? true : false;
}
							
function addPlace( row, place )
{
	selectedPlaces.push([row,place]);
}

function delPlace( row, place )
{
	for ( i = 0; i < selectedPlaces.length; i++ )
	{
		var isNeedlePlace = ( selectedPlaces[i][0] == row ) && ( selectedPlaces[i][1] == place )
		if ( isNeedlePlace )
		{
			selectedPlaces.splice(i,1);
			break;
		}		
	}
}
							
function printSelected()
{
	var outputString = '';
	for ( i = 0; i < selectedPlaces.length; i++ )
	{
		outputString +=  selectedPlaces[i][0] + ' ряд/' + selectedPlaces[i][1] + ' место; ';
	}
	$('#selected-place').html(outputString);
}						
							
});//end ready