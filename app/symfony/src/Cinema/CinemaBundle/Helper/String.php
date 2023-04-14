<?php

namespace Alians\StoneBundle\Helper;

use Alians\StoneBundle\Helper\Setting;

class String
{
    /**
     * convert film name string in russian to Folm slug(translit)
     * @param string $name Enyity name
     * @return string Entity slug
     **/
    public static function name2slug( $name )
    {
        $name = iconv( Setting::ENCODE_DEST, Setting::ENCODE_SOURCE . '//IGNORE', $name );
        $name = strtolower( $name );
        $lenName = strlen( $name );
        $replace = self::getReplaceArray();
        $slug = '';
        for ( $i = 0; $i < $lenName; $i++ )
        {
            if ( array_key_exists( $name{$i}, $replace ) )
            {
                $slug .= $replace[$name{$i}];
            }
            else
            {
                if ( in_array( $name{$i}, $replace ) )
                    $slug .= $name{$i};
            }
        }
        return $slug;
    }//end func
    
    private static function getReplaceArray()
    {
    return array( 
                            ' ' => '-', 
                            'à' => 'a',
                            'À' => 'a',
                            'á' => 'b',
                            'Á' => 'b',
                            'â' => 'v', 
                            'Â' => 'v',
                            'ã' => 'g',
                            'Ã' => 'g',
                            'ä' => 'd',
                             'Ä' => 'd',
                            'å' => 'e',
                             'Å' => 'e',
                            '¸' => 'yo',
                             '¨' => 'yo',
                            'æ' => 'zh',
                             'Æ' => 'zh',
                            'ç' => 'z',
                            'Ç' => 'z',
                            'è' => 'i', 
                            'È' => 'i', 
                            'é' => 'iy',
                            'É' => 'iy',
                            'ê' => 'k',
                            'Ê' => 'k', 
                            'ë' => 'l',
                            'Ë' => 'l', 
                            'ì' => 'm',
                            'Ì' => 'm',
                            'í' => 'n',
                            'Í' => 'n', 
                            'î' => 'o',
                            'Î' => 'o', 
                            'ï' => 'p',
                            'Ï' => 'p', 
                            'ğ' => 'r',
                            'Ğ' => 'r',
                            'ñ' => 's',
                            'Ñ' => 's',
                            'ò' => 't',
                            'Ò' => 't',
                            'ó' => 'u',
                            'Ó' => 'u', 
                            'ô' => 'f',
                            'Ô' => 'f', 
                            'õ' => 'h',
                            'Õ' => 'h',
                            'ö' => 'ch',
                            'Ö' => 'ch',
                            '÷' => 'ch',
                            '×' => 'ch', 
                            'ø' => 'sh', 
                            'Ø' => 'sh', 
                            'ù' => 'sh',
                            'Ù' => 'sh', 
                            'ú' => '',
                            'Ú' => '',
                            'û' => 'i',
                            'Û' => 'i',
                            'ü' => '',
                            'Ü' => '',
                            'ı' => 'e',
                             'İ' => 'e',
                            'ş' => 'yu',
                            'Ş' => 'yu',
                            'ÿ' => 'ya',
                            'ß' => 'ya', 
                            '/' => '', 
                            '.' => '', 
                            ':' => '', 
                            '\\' => '',
                            '1' => '1',
                            '0' => '0',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9'
                            
                );
    
    }//end func
    
    
}//end class

/**
 * function return array to convert string in russian to translit 
 **/

