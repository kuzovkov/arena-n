<?php

namespace Alians\StoneBundle\Helper;

class Container
{
    static $container;
    
    static function setContainer($key,$value)
    {
        self::$container[$key] = $value;
    }//end func
    
    static function getContainer($key)
    {
        return (isset(self::$container[$key]))? 
            self::$container[$key] : false;
    }//end func
    
    
}//end class