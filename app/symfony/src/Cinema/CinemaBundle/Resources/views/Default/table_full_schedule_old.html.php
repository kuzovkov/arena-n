<?php
    $seances3 = array();
    
    foreach( $data['seances'] as $filmId => $seancesFilm )
    {
        foreach( $seancesFilm as $room => $seances )
        {
            foreach( $seances as $seance )
            {
                $seances3[$filmId][$room][] = $seance;   
            }
        }
    }
    
   
?>
<a id="prev" title="Назад"><<</a>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="date-schedule <?php if( $data['dayweek'] == 0 || $data['dayweek'] == 6 ) echo 'weekend';?>"><?php echo $data['date'];?>,&nbsp;<?php echo $days[$data['dayweek']];?></span>
&nbsp;&nbsp;&nbsp;&nbsp;<a title="Вперед" id="next">>></a>

<table class="rasp-table" border="1" cellspacing='0' cellpadding='0' align='center'>
<tr>
<th class="film">Фильм</th>
<th class="room">Зал</th>
<th class="seance">Сеансы</th>
<th class="prices">Цены</th>
</tr>
<?php foreach( $seances3 as $filmId => $seancesFilm ):?>
    <tr height="80">
        <td class="film">
        <div class="film-wrapper">
            <?php echo '<p class="film-name imghide">' . $data['seances'][$filmId]['film']->getName() . '&nbsp;<span class="age">' . $data['seances'][$filmId]['film']->getAgelimit() . '+</span><br/>';
                echo '<span class="desc"><em>( ' .  $data['seances'][$filmId]['film']->getGenre() . '&nbsp; )<br/>Продолжительность:&nbsp;' . $data['seances'][$filmId]['film']->getDuration() .'</em>';
            ?>
            <?php  
                $name = $filmId . '.jpg';
            ?>
            <br/><img src="/upload/images/film/<?php echo $name;?>" /></p>
        </div>    
        </td>
        <td colspan="3" width="650" height="80">
            <table class="inner" width="100%" height="100%" cellspacing='0' cellpadding='0'>
                <?php foreach( $seancesFilm as $room => $seancesInRoom ):?>
                <tr>
                    <td class="room" width="50">
                        <?php echo $room; ?>
                    </td>
                    <td class="time">
                        <?php foreach( $seancesInRoom as $seance ):?>
                            <a href="#" title="Цена билета <?php echo $seance->getPrice()?> руб."><?php echo  $seance->getTimeBegin()->format('H:i'); ?></a>&nbsp;
                        <?php endforeach;?>
                    </td>
                    <td class="price">
                        <?php   $prices = array();
                                
                                foreach( $seancesInRoom as $seance )
                                {
                                    $price = $seance->getPrice();
                                    $time = $seance->getTimeBegin()->format('H:i');
                                    if ( array_key_exists( $price, $prices ) )
                                    {
                                        $prices[$price] .= ', ' . $time;
                                    }
                                    else
                                    {
                                        $prices[$price] = $time;
                                    }
                                } 
                                foreach( $prices as $price => $times ):        
                        ?>
                                
                            <a href="#" title="Время сеанса: <?php echo $times;?>"><?php echo  $price; ?></a>&nbsp;
                        <?php endforeach;?>
                    </td>
                </tr>
                
                <?php endforeach;?>
                
            </table>
        </td>
        
    </tr>
<?php endforeach; ?>

<script type="text/javascript">
var minDay = 0;
var maxDay = 8;

hideBtn();

$('a[title]').qtip();
 $('a[title]').click(function(ev){ev.preventDefault();});
$('#prev').click(function(){ if( day > minDay )day--; showPreload(); loadSchedule();});
$('#next').click(function(){ if( day < maxDay )day++; showPreload(); loadSchedule();});

function showPreload()
{
      $('#schedule_all_films').html('<img class="preload" src="/bundles/cinemacinema/images/725.gif"/>');  
}

function hideBtn()
{
    
    if(day == minDay )
    {
        $('#prev').css('color', '#ffffff');
    }
    else
    {
         $('#prev').css('color', '#b44044')
    }
    
    if(day == maxDay )
    {
        $('#next').css('color', '#ffffff');
    }
    else
    {
         $('#next').css('color', '#b44044')
    }
     
   
}

$('p.film-name').hover(function(){ 

                                    $(this).removeClass('imghide');
                                    $(this).addClass('imgshow');
                                 
                                        
                                        },
                        function(){     
                                       
                                        $(this).removeClass('imgshow');
                                        $(this).addClass('imghide');
                                        
                                    }
                                        
                                        );

</script>

