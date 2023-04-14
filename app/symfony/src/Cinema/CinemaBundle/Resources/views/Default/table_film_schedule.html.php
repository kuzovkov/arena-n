<?php
     $roomName = array(0,1,2,3,4,'VIP');/*array for rename room number to name*/
    $seances2 = array();

    foreach( $data['seances'] as $room => $seances )
    {
        foreach( $seances as $seance )
        {
            $date = $seance->getTimeBegin()->format('d.m');
            $seances2[$room][$date][] = $seance;   
        }
    }
    
    //print_r($seances2); exit();
    $roomItems = array();
    foreach( $seances2 as $room => $seancesInRoom )
    {
        $roomItems[$room] = count( $seancesInRoom );
    }
    //print_r($roomItems); exit();
   
?>

<table class="b-shed">
<tbody>

<?php foreach( $seances2 as $room => $seancesInRoom ): 
        $newRoom = true; 
?>
        <tr>
            <td class="td-z" colspan="3">
                Зал <?php echo $roomName[$room]; ?>
            </td>
        </tr>   
    <?php $odd = false; foreach( $seancesInRoom as $date => $seancesInDate ): ?>
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
        <?php if ( $newRoom ){ $newRoom = false;?>
        <td class="td-f" rowspan="<?php echo $roomItems[$room];?>">Формат <?php echo ( $is3d )? '3D' : '2D';?></td>
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
<?php endforeach;?>
</tbody>
</table>

<script type="text/javascript">
        $('a[title]').qtip();
        $('a.title').click(function(ev){ev.preventDefault();});
</script>