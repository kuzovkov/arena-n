<?php

namespace Cinema\CinemaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CinemaCinemaBundle extends Bundle
{
    const BASE_PATH = '/var/www/html/';
    const BASE_URL = 'https://arena.kuzovkov12.ru/';
    const PAGE_IMG_DIR = 'web/upload/images/pages';
    const PAGE_IMG_URL = 'https://arena.kuzovkov12.ru/upload/images/pages/';
    const FILM_TRAILER_URL = 'https://arena.kuzovkov12.ru/upload/trailers/';
    const TRAILER_DIR = 'web/upload/trailers';
    const DATETIME_FORMAT1 = 'Y-m-d 00:00:00';
    const DATETIME_FORMAT2 = 'Y-m-d 23:59:59';
    const DATETIME_FORMAT = 'Ymd';
    const SEC_IN_DAY = 86400;
    const UPLOAD_NEWS_DIR = 'web/upload/images/news';
    const UPLOAD_BANNER_DIR = 'web/upload/images/banners';
    const BANNER_URL = 'upload/images/banners/';
    const IMG_NAME_URL = 'upload/images/names';
	const IMG_WALL_URL = 'upload/images/film_wall';
    const NEWS_LIMIT = 5;
    const REG_EXP_URL = '/^https:\/\/www.kinopoisk.ru\/film\/[0-9]{1,}/';
    const ENCODE_SOURSE = "windows-1251";
    const ENCODE_DEST = "utf-8";
    const IMG_DIR = 'web/upload/images/film';
    const IMG_BIG_DIR = 'web/upload/images/film_big';
    const IMG_WALL_DIR = 'web/upload/images/film_wall';
    const IMG_NAME_DIR = 'web/upload/images/names';
    const IMG_EXT = '.jpg';
    const NAMES = 'SET NAMES "utf8"';
    const MAXAGE = 6;
    const EXPIRES = '+6 seconds';
    
}
