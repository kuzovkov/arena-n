<?php
    
    $roomName = array(0,1,2,3,4,'VIP');/*array for rename room number to name*/
    $seances3 = array();
    //print_r($data['seances']);exit();
    
    foreach( $data['seances'] as $filmId => $seancesFilm )
    {
        
        foreach( $seancesFilm['seances'] as $seance )
        {
            //$price = $seance->getPrice();
            //$seances3[$filmId][$price][] = $seance;
            $seances3[$filmId][] = $seance;   
        }
        
    }
    
    $filmRowSpan = array();
                                                        
    foreach( $seances3 as $filmId => $seancesFilm )
    {
        $filmRowSpan[$filmId] = isset( $filmRowSpan[$filmId] )? $filmRowSpan[$filmId] + count( $seancesFilm ) : count( $seancesFilm );
    }
    
    //print_r($seances3); exit();
   
?>
<a id="prev" title="Назад"><<</a>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="date-schedule <?php if( $data['dayweek'] == 0 || $data['dayweek'] == 6 ) echo 'weekend';?>"><?php echo $data['date'];?>,&nbsp;<?php echo $days[$data['dayweek']];?></span>
&nbsp;&nbsp;&nbsp;&nbsp;<a title="Вперед" id="next">>></a>

<table class="rasp-table" border="1" cellspacing='0' cellpadding='0' align='center'>
<tr>
<th class="film">Фильм</th>
<th class="seance">Сеансы</th>
<th class="prices">Цены</th>
<th class="room">Зал</th>
</tr>
<?php     
    $currentFilmId=-1;
    foreach( $seances3 as $filmId => $seancesFilm ):
        //$currentRoom = -1;
        foreach( $seancesFilm as $seance ):
            //foreach( $seancesInRoom as $price => $seancesWithPrice ):
                            
?>
    <tr>
        <?php if ( $currentFilmId != $filmId ): $currentFilmId = $filmId; ?>
        <td class="film" rowspan="<?php echo $filmRowSpan[$filmId];?>">
        <div class="film-wrapper">
            <?php echo '<p class="film-name imghide">' . '<a href="'. $view['router']->generate('cinema_cinema_film',array('slug'=>$data['seances'][$filmId]['film']->getSlug()),true) .'">' . $data['seances'][$filmId]['film']->getName() . '</a>&nbsp;<span class="age">' . $data['seances'][$filmId]['film']->getAgelimit() . '+</span><br/>';
                echo '<span class="desc"><em>( ' .  $data['seances'][$filmId]['film']->getGenre() . '&nbsp; )<br/>Продолжительность:&nbsp;' . $data['seances'][$filmId]['film']->getDuration() .'</em>';
            ?>
            <?php  
                $name = $filmId . '.jpg';
            ?>
            <br/><img src="/upload/images/film/<?php echo $name;?>" /></p>
        </div>    
        </td>
        <?php endif; ?>
     
        
        <td class="time">
            <a class='qtip-time title' href="#" title="<?php echo $seance->getPrice(); ?> руб"><?php echo $seance->getTimeBegin()->format('H:i'); ?></a>
        </td>
        <td class="price">
                        <a class='qtip-price title' title=""><?php echo $seance->getPrice(); ?>&nbsp;руб</a>             
       </td>
       <td class="room">
            <?php echo $roomName[$seance->getNumberRoot()];?>
       </td>             
    </tr>           
                 <?php endforeach;?>          
               <?php endforeach;?>

</table>
<script type="text/javascript">
var minDay = 0;
var maxDay = 18;
var nextPresent = false;
<?php if ( $areseancetomorrow === true )
        {
            echo 'nextPresent = true;';
        }
        else
        {
            echo 'nextPresent = false;';
        }  
?>

hideBtn();
doNewHeightSchedule();


//$('#prev').qtip({show:{solo:true}});
//$('#next').qtip({show:{solo:true}});
$('.qtip-price').qtip();
$('.qtip-time').qtip();


 $('a.title').click(function(ev){ev.preventDefault();});
$('#prev').click(function(){ if( day > minDay )day--; showPreload(); loadSchedule();});
$('#next').click(function(){ if( day < maxDay )day++; showPreload(); loadSchedule();});

function showPreload()
{
      $('#schedule_all_films').html('<img class="preload" src="/bundles/cinemacinema/images/725.gif"/>');  
}

function doNewHeightSchedule() {
    
    var colheight = $(window).height() - 270 - 236;
	var realHeight = $('.rasp-table').height() + 70;
   
	if ( realHeight <= colheight )
	{
        $('.wrap-content').css('height',colheight+'px');
	}
    else
    {
        $('.wrap-content').css('height','auto');
    }
};

function hideBtn()
{
    
    if(day == minDay )
    {
        $('#prev').hide();
    }
    else
    {
         $('#prev').show();
    }
    
    if(day == maxDay || (nextPresent == false))
    {
        $('#next').hide();
    }
    else
    {
         $('#next').show();
    }
     
   
}

$('p.film-name').hover(function(){ 

                                    $(this).removeClass('imghide');
                                    $(this).addClass('imgshow');
                                    $('footer').css('zIndex',1);
                                 
                                        
                                        },
                        function(){     
                                       
                                        $(this).removeClass('imgshow');
                                        $(this).addClass('imghide');
                                        $('footer').css('zIndex',2);
                                        
                                    }
                                        
                                        );

</script>

