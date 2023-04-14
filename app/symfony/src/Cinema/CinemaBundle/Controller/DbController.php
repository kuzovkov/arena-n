<?php

namespace Cinema\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class DbController extends Controller
{
    
    public function dbcreateAction($name)
    {
        $name;
        if (!file_exists($name))exit( 'file "' . $name . '" not exists!');
        $f = fopen( $name, "r" );
        if ( !$f )exit("Can not open file $name"); 
        
        $dump = '';
        
        while( !feof($f) )
        {
            $line = fgets($f, 4096 );
            if ( $line{0} == '-' && $line{1} == '-' ) continue;
            if ( ($line == '' ) ) continue;
            $dump .= $line;
        }
        //echo $dump;
        
        $commands = explode(";\n",$dump);
        foreach($commands as $command )
        {
            $command = trim( $command );
            if ( $command != '' ) $this->query($command);
        }
        echo 'Done';
        exit();
    }//end func
    
   public function query($sql)
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        return $conn->executeQuery($sql);
    }//end func


}