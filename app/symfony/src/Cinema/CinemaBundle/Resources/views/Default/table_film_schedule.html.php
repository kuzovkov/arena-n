<?php
     $roomName = array(0,1,2,3,4,'VIP',6);/*array for rename room number to name*/
    $seances2 = array();

    foreach( $data['seances'] as $room => $seances )
    {
        foreach( $seances as $seance )
        {
            $date = $seance->getTimeBegin()->format('d.m');
            $format = ($seance->getIs3d())? '3d':'2d';
            $seances2[$room][$format][$date][] = $seance;   
        }
    }
    
    //print_r($seances2); exit();
    $roomItems = array();
    foreach( $seances2 as $room => $seancesInRoom )
    {
        foreach( $seancesInRoom as $format => $seancesInRoomFormat)
        {
            $roomItems[$room][$format] = count( $seancesInRoomFormat );
        }
        
    }
    //print_r($roomItems); exit();
   
?>

<table class="b-shed">
<tbody>

<?php foreach( $seances2 as $room => $seancesInRoom ): 
        $newRoom = true;
        $format2D = true;
        $format3D = true; 
?>
        <tr>
            <td class="td-z" colspan="3">
                Зал <?php echo $roomName[$room]; ?>
            </td>
        </tr>   
    <!-- вывод сеансов 3D -->
    <?php if (isset($seancesInRoom['3d'])): //if 3d seances are present?>
    <?php $odd = false; foreach( $seancesInRoom['3d'] as $date => $seancesInDate ): ?>
    
    <?php 
        if ( $odd )
        {
            echo '<tr class="tr-odd">'; $odd = false;
        }
        else
        {
            echo '<tr>'; $odd = true;
        }
    ?>
        <?php if ( $newRoom && $format3D ){ $newRoom = false; $format3D = false;?>
        <td class="td-f" rowspan="<?php echo $roomItems[$room]['3d'];?>">Формат <?php echo ( $is3d )? '3D' : '3D';?></td>
        <?php } ?>
        <td><?php 
                $i = $seancesInDate[0]->getTimeBegin()->format('w');
                echo $days[$i] . ', ';
                echo $seancesInDate[0]->getTimeBegin()->format('d.m');
                
            ?>
        </td>
        <td class="time">
            <?php foreach( $seancesInDate as $seance ): ?>
            <a class="seance-link title" href="" title="Цена билета: <?php echo $seance->getPrice();?> руб.">
                <?php echo $seance->getTimeBegin()->format('H:i'); ?>
             </a> &nbsp;   
            <?php endforeach; ?>
        </td>
    </tr>

    <?php endforeach; ?>
    <tr><td></td></tr>
   
    <?php if (isset($seancesInRoom['2d']) ):?>
    <tr class="h-line"><td colspan="3"></td></tr>
    <?php endif; ?>
    <?php endif; //end if 3d seances are present?>
        
  <!-- вывод сеансов 2D -->
    <?php if ( isset($seancesInRoom['2d']) ): //if 2d seances are present?>
     
    <?php $odd = false; foreach( $seancesInRoom['2d'] as $date => $seancesInDate ): ?>
    
    <?php 
        if ( $odd )
        {
            echo '<tr class="tr-odd">'; $odd = false;
        }
        else
        {
            echo '<tr>'; $odd = true;
        }
    ?>
        <?php if ( $format2D){ $format2D = false;?>
        <td class="td-f" rowspan="<?php echo $roomItems[$room]['2d'];?>">Формат <?php echo ( $is3d )? '2D' : '2D';?></td>
        <?php } ?>
        <td><?php 
                $i = $seancesInDate[0]->getTimeBegin()->format('w');
                echo $days[$i] . ', ';
                echo $seancesInDate[0]->getTimeBegin()->format('d.m');
                
            ?>
        </td>
        <td class="time">
            <?php foreach( $seancesInDate as $seance ): ?>
            <a class="seance-link title" href="" title="Цена билета: <?php echo $seance->getPrice();?> руб.">
                <?php echo $seance->getTimeBegin()->format('H:i'); ?>
             </a> &nbsp;   
            <?php endforeach; ?>
        </td>
    </tr>

    <?php endforeach; ?>
    <tr><td></td></tr>
    <?php endif; //end if 2d seances are present?>
    
    
<?php endforeach;?>
</tbody>
</table>

<script type="text/javascript">
        $('a[title]').qtip();
        $('a.title').click(function(ev){ev.preventDefault();});
</script>