<?php
    $out = '';
    if (is_array($files))
    {
        foreach( $files as $name => $url )
        {
            $out .= "{title: '$name', value: '$url'},"; 
        }
        $out = substr( $out, 0, strlen( $out ) - 1 );
    }
    echo $out;

?>