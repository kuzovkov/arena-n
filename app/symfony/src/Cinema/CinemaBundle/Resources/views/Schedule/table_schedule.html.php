 <table class="simple-little-table">
 <?php
     $roomName = array(0,1,2,3,4,'VIP');/*array for rename room number to name*/
     $span = array();
		foreach( $seances as $seance )
		{
			$date = $seance->getTimeBegin()->format('d.m');
			if ( array_key_exists( $date, $span ) === false )
			{
				$span[$date] = 1;
			}
			else
			{
				$span[$date]++;
			}
		}
		
		$prev = '';
        $trclass = 'even';
  ?> 
     <?php foreach( $seances as $seance ): ?>
        <?php if ( $seance->getTimeBegin()->format('d.m') != $prev ) { $trclass = ( $trclass == 'odd' )? 'even' : 'odd'; } ?>
        <tr class="<?php echo $trclass; ?>">
        <?php if ( $seance->getTimeBegin()->format('d.m') != $prev ) { ?>
            
            <td class="date" rowspan="<?php echo $span[$seance->getTimeBegin()->format('d.m')] ?>">
                <?php echo $seance->getTimeBegin()->format('d.m');?> 
                 <?php $i = $seance->getTimeBegin()->format('w'); ?>
                 (<?php echo $days[$i];?>)
            </td>
            <?php } ?>
            <?php $prev = $seance->getTimeBegin()->format('d.m'); ?>
            
            <td class="time"><?php echo $seance->getTimeBegin()->format('H:i');?></td>
            <td class="price"><?php echo $seance->getPrice();?></td>
            <td class="room"><?php echo $roomName[$seance->getNumberRoot()];?></td>
            <td class="del"><a title="Удалить"><img class="del-seance" id="<?php echo $seance->getId();?>" src="/bundles/cinemacinema/images/delete-48.png" title="Удалить"/></a></td>
        </tr>
     
     <?php endforeach; ?>
 </table>
 <?php if ( $error ) { ?>
    <script type="text/javascript">
        $(function() {
                        
                        $( "#dialog-message" ).dialog({
                          modal: true,
                          buttons: {
                            Ok: function() {
                              $( this ).dialog( "close" );
                            }
                          }
                        });
                      });
           
    </script>
 <div id="dialog-message" title="Ошибка">
  <p>
    <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
    Данные не были добавлены!
  </p>
  <p>
    Причина: указанные вами данные <br/>могут привести к накладкам в расписании</b>.
  </p>
</div>
    
 
 <?php } ?>
 
 <script type="text/javascript">
$(document).ready(function(){
    $('a[title]').qtip();
    $('.del-seance').click(function(){
                var id = this.id;
                var film_id = $('ul.breadcrumb li.active').text();
                $('#schedule_table').load("<?php echo $view['router']->generate('cinema_cinema_admin_del_schedule_record');?>",{id:id, film_id:film_id});
                $('#schedule_error').load("<?php echo $view['router']->generate('cinema_cinema_admin_check_error_schedule');?>",{id:film_id});
                setTimeout( function(){
                    $('#schedule_error').load("<?php echo $view['router']->generate('cinema_cinema_admin_check_error_schedule');?>",{id:film_id});
                }, 2000 );
                
    });
});
 </script>   
 