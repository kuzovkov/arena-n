<?php

namespace Cinema\ParseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Cinema\CinemaBundle\Entity\Film;
use Cinema\ParseBundle\CinemaParseBundle;

require_once( 'simple_html_dom.php' );

class ParserController extends Controller
{
     
   public $headers = array(
                				 'Cache-Control: max-age=0',
                				 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                				 'Accept-Encoding: ',
                				 'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4'
				            );
   
    
   /**
    *   get content web page and return need data in array $filmInfo
    *   @param string $url Url on site kinppoisk.ru
    *   @return array $filmInfo Array need data about film 
    */ 
   
   public function parseAction( $url )
   {
        $content = $this->SendRequest( $url, false, $this->headers );
        $filmInfo = $this->parseContent( $content );
        if ( $filmInfo === false ) return false;
        if ( strrpos( $url, '/' ) !== ( strlen($url) - 1 ) ) $url .= '/';
        $urlWall = $url . 'wall/';
        $contentWall = $this->SendRequest( $urlWall, false, $this->headers );
        $srcWall = $this->getWallUrl( $contentWall );
        $filmInfo['wall_url'] = ( $srcWall )? $srcWall : '';
        $url .= 'dates/';
        $content = $this->SendRequest( $url, false, $this->headers );
        $filmInfo['date_last'] = $this->string2timestamp( $this->getDateLast( $content ) );
        return $this->decodeString( $filmInfo );  
   }//end func
   
    /**
    *   converting encode of all string item in array $filmInfo
    *   @param array $filmInfo Array need data about film 
    *   @return array $filmInfo Array need data about film 
    */ 
    protected function decodeString( $filmInfo )
    {
         foreach( $filmInfo as $key => $value )
            {
                if ( ( ! is_numeric( $value ) ) && ( ! is_bool( $value ) ) )
                {
                     $filmInfo[$key] = iconv( CinemaParseBundle::ENCODE_SOURSE, 
                                CinemaParseBundle::ENCODE_DEST . '//IGNORE', $value ); 
                }
            }
        return $filmInfo;
    }//end func
    
    /**
    *   Parsing web page content to array $filmInfo
    *   @param string $content String HTML code of web page
    *   @return array $filmInfo Array need data about film 
    */
    protected function parseContent( $content )
    {
        $filmInfo = array();
        
        $html = str_get_html( $content );
        if ( is_object($html) )
        {
            $filmInfo['agelimit'] = $this->getAgeLimit( $html );
            $filmInfo['genre'] = $this->getGenre( $html );
            $filmInfo['poster_small'] = $this->getPosterSmall( $html );
            $filmInfo['poster_big'] = $this->getPosterBig( $html );
            $filmInfo['duration'] = $this->getDuration( $html );
            $filmInfo['country'] = $this->getCountry( $html );
            $filmInfo['description'] = $this->getDescription( $html );
            $filmInfo['director'] = $this->getDirector( $html );
            $filmInfo['is3d'] = false;
            $filmInfo['date_first'] = $this->getDateFirst( $html );
            $filmInfo['name'] = $this->getName( $html );
            $filmInfo['name_en'] = $this->getNameEn( $html );
            $filmInfo['year'] = $this->getYear( $html );
            $filmInfo['budget'] = $this->getBudget( $html );
            $filmInfo['date_first_world'] = $this->getDateFirstWorld( $html );
            $filmInfo['rating'] = $this->getRating( $html );
            $filmInfo['wall_present'] = false;        
        }
        return $filmInfo;
    }//end func
    
    /**
    *   Parsing web page content to extract age limit
    *   @param object $html Simple html dom object
    *   @return int Age limit 
    */
    protected function getAgeLimit( $html )
    {
        /*age limit */
        $age = array( 0, 0 );
        $result = $html->find( 'div[class=ageLimit]', 0 );
        if ( !is_object( $result ) ) return 0;
        preg_match( '#[0-9]{1,}#', $result->next_sibling()->innertext, $age );
        return (isset($age[0]))? intval( $age[0] ) : 0;  
        
    }//end func
    
    /**
    *   Parsing web page content to extract genre
    *   @param object $html Simple html dom object
    *   @return string $genre Genres of film
    */
    protected function getGenre( $html )
    {
        /*genre*/
        $genre = '';
        $result = $html->find( 'a[href*=genre]');
        if ( !is_array( $result ) ) return '';
        foreach( $result as $item )
        {
            if ( !is_object( $item ) ) continue;
            $genre .= $item->innertext . ', ';
        }
        return $genre;
    }//end func
    
    
    /**
    *   Parsing web page content to extract url poster small
    *   @param object $html Simple html dom object
    *   @return string Url of poster small
    */
    protected function getPosterSmall( $html )
    {
        /*poster*/
        $poster = array();
        $result = $html->find( 'a[onclick*=openImgPopup]', 0 );
        if ( !is_object( $result ) ) return '';
        preg_match( '/[0-9]{1,}.jpg/', $result->onclick, $poster );
        //return ( $poster[0] )? CinemaParseBundle::KINOPOISK_URL . 'images/film/' . $poster[0] : '-';
        return ( $poster[0] )? CinemaParseBundle::YANDEX_URL . 'images/film/' . $poster[0] : '-';
    }//end func
    
    /**
    *   Parsing web page content to extract url poster big
    *   @param object $html Simple html dom object
    *   @return string Url of poster big
    */
    protected function getPosterBig( $html )
    {
        /*poster*/
        $poster = array();
        $result = $html->find( 'a[onclick*=openImgPopup]', 0 );
        if ( !is_object( $result ) ) return '';
        preg_match( '/[0-9]{1,}.jpg/', $result->onclick, $poster );
        //return ( $poster[0] )? CinemaParseBundle::KINOPOISK_URL . 'images/film_big/' . $poster[0] : '-';
        return ( $poster[0] )? CinemaParseBundle::YANDEX_URL . 'images/film_big/' . $poster[0] : '-';
    }//end func
    
    /**
    *   Parsing web page content to extract duration of film
    *   @param object $html Simple html dom object
    *   @return int duration of film in minutes 
    */
    protected function getDuration( $html )
    {
         /*duration*/
        $dur = array(0,0);
        $result = $html->find( 'td#runtime', 0 );
        if ( !is_object( $result ) ) return 0;
        $str = $result->innertext;
        preg_match( '/\d{1,}/', $str, $dur );
		return (isset($dur[0]))? intval($dur[0]) : 0;
        
    }//end func
    
    /**
    *   Parsing web page content to extract contries
    *   @param object $html Simple html dom object
    *   @return string contries
    */
    protected function getCountry( $html )
    {
        /*country*/
        $countries = array();
		$result = $html->find( 'a[href*=country]' );
		if ( is_array( $result ) && count( $result ) )
		{
            foreach( $result as $item )
            {
                if ( !is_object( $item ) ) '';
                if ( $item->innertext ) $countries[] = $item->innertext;
            }
		}
		return implode( ',', $countries );
        
    }//end func
    
    /**
    *   Parsing web page content to extract description of film
    *   @param object $html Simple html dom object
    *   @return string Description of film
    */
    protected function getDescription( $html )
    {
        /*description*/
        $result = $html->find( 'div[itemprop=description]', 0 );
        if ( !is_object( $result ) ) return '';
        return $result->innertext;
        
    }//end func
    
    /**
    *   Parsing web page content to extract director of film
    *   @param object $html Simple html dom object
    *   @return string Director of film
    */
    protected function getDirector( $html )
    {
        /*director*/
        $result = $html->find( 'td[itemprop=director] a', 0 );
        if ( !is_object( $result ) ) return '';
        return $result->innertext;
        
    }//end func
    
    /**
    *   Parsing web page content to extract date first show
    *   @param object $html Simple html dom object
    *   @return timestamp date first show
    */
    protected function getDateFirst( $html )
    {
        /*date_first*/
        $result = $html->find( 'a[href^=/premiere/ru/]', 0 );
        if ( !is_object( $result ) ) return 0;
        $date_first = $this->string2timestamp( $result->innertext );
        return ( $date_first == 0 )? time() : $date_first;
    }//end func
    
    /**
    *   Parsing web page content to extract name of film 
    *   @param object $html Simple html dom object
    *   @return string Name of film
    */
    protected function getName( $html )
    {
         /*name*/
         $result = $html->find( 'h1[class=moviename-big]', 0 );
         if ( !is_object( $result ) ) return 'noname';
         $name = $result->innertext;
         return ereg_replace('&[#0-9a-z]{1,};', '', $name);
        
    }//end func
    
    /**
    *   Parsing web page content to extract english name of film 
    *   @param object $html Simple html dom object
    *   @return string English Name of film
    */
    protected function getNameEn( $html )
    {
         /*name-en*/
        $result = $html->find('span[itemprop=alternativeHeadline]', 0);
        if ( !is_object( $result ) ) return '';
        $name_en = $result->innertext;
        return ereg_replace('&[#0-9a-z]{1,};', '', $name_en);
    }//end func
    
    /**
    *   Parsing web page content to extract year film created
    *   @param object $html Simple html dom object
    *   @return int Year film created
    */
    protected function getYear( $html )
    {
         /*year*/
        $result = $html->find( 'a[href*=year]', 0 );
        if ( !is_object( $result ) ) return 0;
        return intval( $result->innertext );
        
    }//end func
    
    /**
    *   Parsing web page content to extract budget of film 
    *   @param object $html Simple html dom object
    *   @return int Budget of film
    */
    protected function getBudget( $html )
    {
         /*budget*/
        $result = $html->find( 'td.dollar div a',0 );
        if ( is_object( $result ) )
        {
            $result = $result->innertext;
            $budget = '';
    		for( $i = 0; $i < strlen( $result ); $i++  )
    		{
                if ( $result{$i} >= '0' && $result{$i} <= '9' ) $budget .= $result{$i};
    		}
    		return intval( $budget ); 
        }
        else
        {
            $result = $html->find( 'td.dollar div',0 );
            if ( is_object( $result ) )
            {
                $result = $result->innertext;
                $budget = '';
        		for( $i = 0; $i < strlen( $result ); $i++  )
        		{
                    if ( $result{$i} >= '0' && $result{$i} <= '9' ) $budget .= $result{$i};
        		}
        		return intval( $budget ); 
            }
            return 0;
        }
    }//end func
    
    /**
    *   Parsing web page content to extract date first show in world
    *   @param object $html Simple html dom object
    *   @return timestamp date first show in world
    */
    protected function getDateFirstWorld( $html )
    {
        /*date_first_world*/
        $result = $html->find( 'td[id=div_world_prem_td2]', 0);
		if ( !is_object( $result ) ) return 0;
        $result = $result->find('a', 0);
        if ( !is_object( $result ) ) return 0;
        return $this->string2timestamp( $result->innertext );
    }//end func
    
    /**
    *   Parsing web page content to extract rating of film
    *   @param object $html Simple html dom object
    *   @return string Rating of film
    */
    protected function getRating( $html )
    {
        /*rating*/
        $result = $html->find( 'span[class=rating_ball]', 0);
        if ( !is_object( $result ) ) return '';
        return $result->innertext;
    }//end func
    
    
    /**
    *   extract date of last show film
    *   @param string $content HTML content web page 
    *   @return string $dateLast date last show film
    */
    protected function getDateLast( $content )
    {
        $html = str_get_html( $content );
        if ( is_object($html) )
		{	
			$items = $html->find( 'td[style=white-space: nowrap; padding-right: 50px]' );
			 if ( is_array( $items ) && count( $items ) )
			 {
				
				foreach( $items as $item )
				{
					$dateLast =  trim( $item->plaintext );
				}
				return $dateLast;
			 }
		}
		else
		{
			return '';
		}
        
    }//end func
    
    /**
    *   extract id of film in kinopoisk.ru site
    *   @param string $url Url on site
    *   @return string Id film on kinopoisk.ru
    */
    private function getFilmId( $url )
    {
        if ( $url )
        {
            $array = array();
            if ( preg_match( '/[0-9]{1,}/', $url, $array ) ) return $array[0];
            return false;
        }
        return false;
    }//end func
    
    
    /**
    *   make need dir
    *   @param string $path Path to directory
    *   @return boolean true if Ok false if fail
    */
    protected function makeDir( $path )
    {
        $arrayDir = explode( '/', $path );
        if ( is_array( $arrayDir ) )
        {
            $path = CinemaParseBundle::BASE_PATH; 
            foreach( $arrayDir as $dir )
            {
                $path .= '/' . $dir; 
                if ( !file_exists( $path ) || !is_dir( $path ) ) 
                {
                    if ( !mkdir( $path ) ) return false;
                }
            }
            return true;
        }
        return false;
    }//end func
    
    /**
    *   download big poster image
    *   @param string $url Url Image
    *   @param array $header Array of send headers
    *   @param integer $filmId Film id
    */
    public function loadBigImage( $url, $filmId )
    {
        if ( $url )
        {
            $photo = $this->SendRequest( $url, false, $this->headers );
            if ( !$photo ) return false;
            $dirname = CinemaParseBundle::BASE_PATH . CinemaParseBundle::IMAGE_PATH_BIG;
            if ( !file_exists( $dirname ) || !is_dir( $dirname ) )
            {
                if ( !$this->makeDir( CinemaParseBundle::IMAGE_PATH_BIG )) return false;
            }
            $filename = $dirname . '/' . $filmId . CinemaParseBundle::IMG_EXT;
            return file_put_contents( $filename, $photo );
        } 
        return false;
    }//end func
    
    /**
    *   download small poster image
    *   @param string $url Url Image
    *   @param array $header Array of send headers
    *   @param integer $filmId Film id
    */
    public function loadImage( $url, $filmId )
    {
        if ( $url )
        {
            $photo = $this->SendRequest( $url, false, $this->headers );
            if ( !$photo ) return false;
            $dirname = CinemaParseBundle::BASE_PATH . CinemaParseBundle::IMAGE_PATH;
            if ( !file_exists( $dirname ) || !is_dir( $dirname ) )
            {
                if ( !$this->makeDir( CinemaParseBundle::IMAGE_PATH )) return false;;
            }
            $filename = $dirname . '/' . $filmId . CinemaParseBundle::IMG_EXT;
            return file_put_contents( $filename, $photo );
        }
        return false;
    }//end func
    
    /**
    *   download wall image
    *   @param string $url Url Image
    *   @param array $header Array of send headers
    *   @param integer $filmId Film id
    */
    public function loadWallImage( $url, $filmId )
    {
        if( $url )
        {
            $photo = $this->SendRequest( $url, false, $this->headers );
            if ( !$photo ) return false;
            $dirname = CinemaParseBundle::BASE_PATH . CinemaParseBundle::IMAGE_PATH_WALL;
            if ( !file_exists( $dirname ) || !is_dir( $dirname ) )
            {
                if ( !$this->makeDir( CinemaParseBundle::IMAGE_PATH_WALL )) return false;
            }
            $filename = $dirname . '/' . $filmId . CinemaParseBundle::IMG_EXT;
            return file_put_contents( $filename, $photo );  
        }
        return false;
    }//end func
    
    /**
    *   download trailer file in background
    *   @param string $trailerUrl 
    *   @return string filename of trailer or false if fail
    */
    public function loadTrailer( $trailerUrl )
    {
    	$filename = substr( $trailerUrl, strrpos( $trailerUrl, '/' ) + 1 );
    	$dirname = CinemaParseBundle::BASE_PATH . CinemaParseBundle::TRAILER_PATH;
        if ( !file_exists( $dirname ) || !is_dir( $dirname ) )
        {
            if ( !$this->makeDir( CinemaParseBundle::TRAILER_PATH )) return false;
        }
        //$command = "wget -P " . $dirname . ' ' . $trailerUrl;
        $fullname = CinemaParseBundle::BASE_PATH . CinemaParseBundle::TRAILER_PATH . '/' . $filename;
        $log = CinemaParseBundle::BASE_PATH . CinemaParseBundle::TRAILER_PATH . '/' . CinemaParseBundle::TRAILER_DOWNLOAD_LOG;
        $command = "php download.php $trailerUrl $fullname $log > $log 2>&1 &";
        exec( $command );
    	return ( $filename ) ? $filename : false;
    }//end func
    
     /**
    *   download trailer file with Curl(not tested!!!)
    *   @param string $trailerUrl 
    *   @return string filename of trailer or false if fail
    */
     public function loadTrailerCurl( $trailerUrl )
    {
        $output = array();
        $result = 1;
    	$filename = substr( $trailerUrl, strrpos( $trailerUrl, '/' ) + 1 );
    	$dirname = CinemaParseBundle::BASE_PATH . CinemaParseBundle::TRAILER_PATH;
        if ( !file_exists( $dirname ) || !is_dir( $dirname ) )
        {
            if ( !$this->makeDir( CinemaParseBundle::TRAILER_PATH )) return false;
        }
        $trailer = $this->SendRequest( $trailerUrl, false, $this->headers );
    	if ( !$trailer ) return false;
    	$filename = substr( $trailerUrl, strrpos( $trailerUrl, '/' ) + 1 );
    	return ( file_put_contents( $filename, $trailer ) )? $filename : false;
    }//end func
    
    /**
    *   get trailer url from link as: kinopoisk.ru/film/123456/video/
    *   @param string url Link 
    *   @return string trailer url or false if fail
    */
    public function getTrailerUrl( $url )
    {
        if ( !$url ) return false;
        if ( $this->isAltTrailerLink($url)) return $this->extractStraightTrailerLink($url);
        if ( strrpos( $url, '/' ) !== ( strlen($url) - 1 ) ) $url .= '/';
        $content = $this->SendRequest( $url, false, $this->headers );
        if ( !$content ) return false;
        $pos = strpos($content,'"trailerFile":');
    	if ( $pos === false ) $pos = strpos($content,"'trailerFile':");
    	$str = substr( $content, $pos, 100 );			
    	$regV = CinemaParseBundle::REGV_TRAILER_URL;
    	$array = array( 0, 0 );
    	preg_match( $regV, $str, $array );
        return ( isset( $array[0] ))? trim( CinemaParseBundle::BASE_TRAILER_URL . $array[0] ) : false;
        
    }//end func
    
    /**
    *   detect that given trailer link is straight link
    *   @param string url Link 
    *   @return true or false
    */
    public function isAltTrailerLink($url)
    {
        if ( strripos( $url, CinemaParseBundle::TRAILER_EXT ) === strlen($url)-strlen(CinemaParseBundle::TRAILER_EXT) ) return true;
        return false;
    }//end func
    
    
    /**
    *   extract trailer link from given string
    *   @param string url Given string 
    *   @return string Trailer Url
    */
    public function extractStraightTrailerLink($url)
    {
        return substr($url, strripos($url, 'http://'));
    }//end func
    
    /**
    *   get Wall url from content film page from kinopoisk.ru
    *   @param string $content Content of page
    *   @return string Wall Url or false if fail
    */
    protected function getWallUrl( $content )
    {
        $html = str_get_html( $content );
        if ( is_object($html) )
		{	
			$links = $html->find('table[class=fotos fotos1] a' );
			if ( is_array( $links ) && count( $links ) )
			{
				$maxSize = 0;
				$needLink = '';
				foreach( $links as $link )
				{
					if ( !is_object( $link ) ) return false;
                    $href = $link->href;
					$array = array( 0, 0 );
					preg_match( '/w_size\/\d{1,}/', $href, $array );
					$str = $array[0];
					$str = strrchr( $str, '/');
					$size = intval(substr($str,1));
					if( $size > $maxSize ) 
					{
						$maxSize = $size;
						$needLink = $href;
					}
				}
				$content = $this->SendRequest( CinemaParseBundle::KINOPOISK_URL2 . $needLink, false, $this->headers );
				if( !$content ) return false;
                $html = str_get_html( $content );
				if ( is_object($html) )
				{
					$img = $html->find('img[id=image]', 0);
                    $src = ( is_object( $img ) )? $img->src : false;
					return $src;
				}
			}
        }
        return false;
   }//end func
    
    /**
    *   conerting string as '22 марта 2014' to timestamp
    *   @param string $date Date string 
    *   @return integer $timestamp Timestamp
    */
    protected function string2timestamp( $date )
    {
        $ddmmyyyy = array();
		$items = explode( ' ', $date );
		foreach( $items as $item )
		{
            $item = trim($item);
            if ( ! empty( $item ) ) $ddmmyyyy[] = $item;
		}
		if ( count( $ddmmyyyy) == 2 )
		{
            $day = 1;
            $month = $this->monthConv( $ddmmyyyy[0] );
            $year = intval(  $ddmmyyyy[1] );
		}
		else if ( count( $ddmmyyyy ) == 3 )
		{
            $day = intval( $ddmmyyyy[0] );
            $month = $this->monthConv( $ddmmyyyy[1] );
            $year = intval(  $ddmmyyyy[2] );
		}
		else return false;
		$timestamp =  mktime( 0, 0, 0, $month, $day, $year );
		return $timestamp;
        
    }//end func
    
     /**
    *   conerting month name string as 'марта' to number
    *   @param string $month Month string 
    *   @return integer Number of given month or 0 if fail
    */
    protected function monthConv( $month )
    {
        $month = iconv( CinemaParseBundle::ENCODE_SOURSE, CinemaParseBundle::ENCODE_DEST . '//IGNORE', $month );
        $month = mb_strtolower( $month, CinemaParseBundle::ENCODE_DEST );
        $nameMonths = array(
							'январ',
							'феврал',
							'март',
							'апрел',
							'ма',
							'июн',
							'июл',
							'август',
							'сентябр',
							'октябр',
							'ноябр',
							'декабр',
						);
        foreach( $nameMonths as $numberMonth => $nameMonth )
		{
			if ( strpos( $month, $nameMonth ) !== false ) return $numberMonth + 1;
		}
		return 0;
    }//end func
    
    /**
     * function SendRequest send Http request
     * @param string $url Url
     * @param boolean $typePost GET request or POST request
     * @param  array $headers Array of headers string ( "Name: value" ) 
     * @param  string $post POST-data string
     * @param  string $fileCookie File for save cookie
     * @return string $content | false Content or false if fail
     */
    protected function SendRequest( $url, $typePost = false, $headers = array(), $post = 'op=0', $referer = '' )
    {
        $result     = false;
        $curlHandle = curl_init( $url );
        if ( $curlHandle === false )
        {
            return false;
        }

        $logFile = @fopen( CinemaParseBundle::LOG_FILE, 'a+' );

        curl_setopt( $curlHandle, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curlHandle, CURLOPT_FOLLOWLOCATION, CinemaParseBundle::REDIRECT_ENABLED );
        curl_setopt( $curlHandle, CURLOPT_COOKIEJAR, trim(CinemaParseBundle::COOKIE_FILE) );
        curl_setopt( $curlHandle, CURLOPT_COOKIEFILE, trim( CinemaParseBundle::COOKIE_FILE) );
        curl_setopt( $curlHandle, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $curlHandle, CURLOPT_USERAGENT, CinemaParseBundle::USER_AGENT );
        if ( $referer != '' )
            curl_setopt( $curlHandle, CURLOPT_REFERER, $referer );
        if ( $typePost )
        {
            curl_setopt( $curlHandle, CURLOPT_POST, 1 );
            curl_setopt( $curlHandle, CURLOPT_POSTFIELDS, $post );
        }
        if ( $logFile )
        {
            curl_setopt( $curlHandle, CURLOPT_STDERR, $logFile );
        }

        $content = curl_exec( $curlHandle );
        //$redirect = 2;
        //$content = $this->curl_exec_follow( $curlHandle, $redirect );
        $info    = curl_getinfo( $curlHandle );
        $error   = curl_error( $curlHandle );

        if ( class_exists( 'Logger' ) )
        {
            $logInfo = array( 
                            $info['url'], 
                            $info['total_time'], 
                            $info['download_content_length'], 
                            $error
                        );
            Logger::write( join( ', ', $logInfo ) );
        }

        if ( ! curl_errno( $curlHandle ) )
        {
            $result = true;
        }

        if ( $logFile )
        {
            fclose( $logFile );
        }
        curl_close( $curlHandle );

        return ( $result ) ? $content : false;
     }//end func
     
     
     /**
     * function for emulation followallocation for Curl
     * @param handle $ch Curl Handle
     * @param int  $maxredurect Number of max redurects
     * @return string result of curl_exec
     */
     function curl_exec_follow($ch, &$maxredirect = null) 
     {
  
          // we emulate a browser here since some websites detect
          // us as a bot and don't let us do our job
          $user_agent = CinemaParseBundle::USER_AGENT;
          curl_setopt($ch, CURLOPT_USERAGENT, $user_agent );
        
          $mr = $maxredirect === null ? 5 : intval($maxredirect);
        
          if (ini_get('open_basedir') == '' && ini_get('safe_mode') == 'Off') 
          {
        
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);
            curl_setopt($ch, CURLOPT_MAXREDIRS, $mr);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
          } 
          else 
          {
            
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        
            if ($mr > 0)
            {
              $original_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
              $newurl = $original_url;
              
              $rch = curl_copy_handle($ch);
              
              curl_setopt($rch, CURLOPT_HEADER, true);
              curl_setopt($rch, CURLOPT_NOBODY, true);
              curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
              do
              {
                curl_setopt($rch, CURLOPT_URL, $newurl);
                $header = curl_exec($rch);
                if (curl_errno($rch)) {
                  $code = 0;
                } else {
                  $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                  if ($code == 301 || $code == 302) {
                    preg_match('/Location:(.*?)\n/', $header, $matches);
                    $newurl = trim(array_pop($matches));
                    
                    // if no scheme is present then the new url is a
                    // relative path and thus needs some extra care
                    if(!preg_match("/^https?:/i", $newurl)){
                      $newurl = $original_url . $newurl;
                    }   
                  } else {
                    $code = 0;
                  }
                }
              } while ($code && --$mr);
              
              curl_close($rch);
              
              if (!$mr)
              {
                if ($maxredirect === null)
                trigger_error('Too many redirects.', E_USER_WARNING);
                else
                $maxredirect = 0;
                
                return false;
              }
              curl_setopt($ch, CURLOPT_URL, $newurl);
            }
          }
          return curl_exec($ch);
    }//end func

}//end class
