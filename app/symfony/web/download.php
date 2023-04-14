<?php

$url = '';
$path = '';
$log = '';
if ( isset( $argv[1] ) ) $url = $argv[1];
if ( isset( $argv[2] ) ) $filename = $argv[2];
if ( isset( $argv[3] ) ) $log = $argv[3];

$command = "wget --output-document=" . $filename . " " . $url;
//echo $command;
file_put_contents( $log, date('H:i:s d-m-Y', time()) . ": " . $command . "\n", FILE_APPEND );

exec( $command, $output );

file_put_contents( $log, date('H:i:s d-m-Y', time()) . ": ". implode( "\n", $output ) . "\n", FILE_APPEND );
