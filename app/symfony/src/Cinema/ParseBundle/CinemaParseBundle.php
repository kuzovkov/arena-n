<?php

namespace Cinema\ParseBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CinemaParseBundle extends Bundle
{
     /**
     * @var const string LOG_FILE Log file
     */
    const LOG_FILE = 'log/http.txt';
    const REDIRECT_ENABLED = 1;
    const ENCODE_SOURSE = "windows-1251";
    const ENCODE_DEST = "utf-8";
    
    /**
     * @var const string COOKIE_FILE Cookie file
     */
    const COOKIE_FILE = 'cookie.txt';
    
    /**
     * @var const string USER_AGENT User-Agent string
     */
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.117 Safari/537.36';

    /**
     * @var const string BASE_PATH Base path application folder
     */
    const BASE_PATH = 'C:/www3/symfony1/';
    
    /**
     * @var const string BASE_PATH Base path application folder
     */
    const KINOPOISK_URL = 'http://www.kinopoisk.ru/';
    const KINOPOISK_URL2 = 'http://www.kinopoisk.ru';
    
    /**
     * @var const string IMAGE_PATH Path to small images
     */
    const IMAGE_PATH = 'web/upload/images/film';
    
    /**
     * @var const string IMAGE_PATH_BIG Path to big images
     */
    const IMAGE_PATH_BIG = 'web/upload/images/film_big';
    
    /**
     * @var const string IMAGE_PATH_WALL Path to wall images
     */
    const IMAGE_PATH_WALL = 'web/upload/images/film_wall';
    
    /**
     * @var const string IMG_EXT Extension images files
     */
    const IMG_EXT = '.jpg';
    
    /**
     * @var const string TRAILER_PATH Path to trailers
     */
    const TRAILER_PATH = 'web/upload/images/trailers';
    
    /**
     * @var const string BASE_TRAILER_URL Base of trailers URL
     */
    const BASE_TRAILER_URL = 'http://kp.cdn.yandex.net/';
    
    /**
     * @var const string TRAILER_DOWNLOAD_LOG Trailer download logfile 
     */
    const TRAILER_DOWNLOAD_LOG = 'download.log';
    
    /**
     * @var const string REGV_TRAILER_URL Trailer get URL regV  
     */
    const REGV_TRAILER_URL = '/[0-9]{1,}\/kinopoisk\.ru[_0-9a-zA-Z\-\.]{3,}/';
    
    /**
     * @var const string TRAILER_EXT Extension trailers files
     */
    const TRAILER_EXT = '.mp4';
    
    /**
     * @var const string YANDEX_URL Image store place
     */
    const YANDEX_URL = 'http://st.kp.yandex.net/';
    
}
