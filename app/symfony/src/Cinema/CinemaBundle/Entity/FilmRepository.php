<?php

namespace Cinema\CinemaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Cinema\CinemaBundle\CinemaCinemaBundle;
use Cinema\ParseBundle\Controller\ParserController as Parser;

/**
 * FilmRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
require_once('array.php');

class FilmRepository extends EntityRepository
{
    /**
     * Array with main genres of film
     **/
    protected $mainGenre = array( 'фантастика', 'триллер', 'приключения', 'драма', 'детектив', 'боевик', 'мультфильм', 'комедия' );
    
    /**
     * Array with extensions for wall image file
     **/
    protected $imageExtWall = array( 'jpg', 'jpeg', 'png' );
    
    /**
     * Array with extensions for film name image file
     **/
    protected $imageExtName = array( 'jpg', 'jpeg', 'png' );
    
    
    /**
     * Compare 2 films by date first show
     * @param object $film1 object Film film1
     * @param object $film2 object Folm film2
     * @return int 0 if equivalent, -1 if film1 before, 1 if film1 later
     **/
    public function cmpFilms( Film $film1, Film $film2 )
    {
        if ( $film1->getDateFirst() < $film2->getDateFirst() ) return -1;
        if ( $film1->getDateFirst() > $film2->getDateFirst() ) return 1;
        return 0;
    }//end func
    
    
    /**
     * get films shows begins today
     * @param string $genre Genre of films
     * @return objects array of objects Film
     **/
    public function getFilmsTodayInfo( $genre = 'all' )
    {
        $this->setNames();
        $today = date_create( date( CinemaCinemaBundle::DATETIME_FORMAT1, time() ) );
        $tomorrow = date_create( date( CinemaCinemaBundle::DATETIME_FORMAT1, time() + CinemaCinemaBundle::SEC_IN_DAY ) );
        $dql = "SELECT s.film_id FROM CinemaCinemaBundle:Schedule s WHERE s.time_begin >= :today AND s.time_begin <= :tomorrow";
        $em = $this->getEntityManager();
        $query = $em->createQuery( $dql );
        $query->setParameters( array( 'today' => $today, 'tomorrow' => $tomorrow ));
        $seances = $query->getResult();
        if ( is_array( $seances ) && count( $seances ) )
        {
            $ids = array();
            foreach( $seances as $seance ) $ids[] = $seance['film_id'];
            $ids = array_unique( $ids );
            $films = array();
            $genres = $this->createGenreArray();
            foreach( $ids as $id )
            {
                $film = $this->findOneById($id);
                if( !$film ) continue;
                if ( $genre != 'all' ) 
                    if ( strpos( $film->getGenre(), $genres[$genre] ) === false ) continue;
                $films[] = $film;
            }
            usort( $films, array("Cinema\CinemaBundle\Entity\FilmRepository","cmpFilms"));   
            return $films;
        }
        else return array();
        
    }//end func
    
    /**
     * get films shows begins soon
     * @param string $genre Genre of films
     * @return array of objects Film
     **/
    public function getFilmsSoonInfo( $genre = 'all' )
    {
        $this->setNames();
        $today = date_create( date( CinemaCinemaBundle::DATETIME_FORMAT1, time() ) );
        $tomorrow = date_create( date( CinemaCinemaBundle::DATETIME_FORMAT1, time() + CinemaCinemaBundle::SEC_IN_DAY ) );
        $dqlToday = "SELECT s.film_id FROM CinemaCinemaBundle:Schedule s WHERE s.time_begin >= :today AND s.time_begin <= :tomorrow";
        $em = $this->getEntityManager();
        $query = $em->createQuery( $dqlToday );
        $query->setParameters( array( 'today' => $today, 'tomorrow' => $tomorrow ));
        $seancesToday = $query->getResult();
        $idsToday = array();
        if ( is_array( $seancesToday ) && count( $seancesToday ) )
        {
            foreach( $seancesToday as $seanceToday ) $idsToday[] = $seanceToday['film_id'];
            $idsToday = array_unique( $idsToday );
        }
        
        $dql = "SELECT s.film_id FROM CinemaCinemaBundle:Schedule s WHERE s.time_begin > :tomorrow";
        $em = $this->getEntityManager();
        $query = $em->createQuery( $dql );
        $query->setParameters( array( 'tomorrow' => $tomorrow ));
        $seances = $query->getResult();
        if ( is_array( $seances ) && count( $seances ) )
        {
            $ids = array();
            foreach( $seances as $seance ) $ids[] = $seance['film_id'];
            $ids = array_unique( $ids ); 
            $films = array();
            $genres = $this->createGenreArray();
            foreach( $ids as $id )
            {
                if ( in_array( $id, $idsToday ) === true ) continue;
                $film = $this->findOneById($id);
                if( !$film ) continue;
                if ( $genre != 'all' ) 
                    if ( strpos( $film->getGenre(), $genres[$genre] ) === false ) continue;
                $films[] = $film;
            }
            usort( $films, array("Cinema\CinemaBundle\Entity\FilmRepository","cmpFilms"));    
            return $films;
        }
        else return array();
        
    }//end func
    
    /**
     * get film with slug
     * @param string $slug Slug of films
     * @return object $film object Film or false if film not exists
     **/
    public function getFilmInfo( $slug = '')
    {
        $this->setNames();
        if (!isset($slug)) $slug = '';
        $film = $this->findOneBy(array( 'slug'=> $slug ));
        if ( !$film ) return false;
        return $film;
        
    }//end func
    
    
    /**
     * get film with id
     * @param int $id Id of films
     * @return object $film object Film or false if film not exists
     **/
    public function getFilmById( $id )
    {
        $this->setNames();
        $film = $this->find($id);
        if ( !$film ) return false;
        return $film;
    }//end func
    
    
    /**
     * get all films
     * @return array of objects Film
     **/
    public function getFilms()
    {
        $this->setNames();
        $films = $this->findAll();
        if ( !$films ) return false;
        return $films;
    }//end func
    
    
    /**
     * check that film with slug is not exists
     * @return boolean true if is not exists or false otherwise 
     **/
    public function isSlugFree( $slug )
    {
        $films = $this->findBy( array( 'slug' => $slug ) );
        if ( !$films ) return true;
        return false;
    }//end func


    /**
     * convert string in russian to translit
     * @return string Translit
     **/
    public function translit($str) {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }

    /**
     * convert film name string in russian to Folm slug(translit)
     * @param string $name Film name
     * @return string Film slug
     **/
    public function name2slug( $name )
    {
        $name = iconv( CinemaCinemaBundle::ENCODE_DEST, CinemaCinemaBundle::ENCODE_SOURSE . '//IGNORE', $name );
        $name = strtolower( $name );
        $lenName = strlen( $name );
        $replace = getReplaceArray();
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
    
    /**
     * delete poster image file and schedule records from database
     * for film with id
     * @param int $id Film id
     **/
    public function deletePostersAndSchedule( $id )
    {
        $film = $this->find( $id );
        $url = $film->getPosterBig();
        $name = $id . CinemaCinemaBundle::IMG_EXT;
        $dql = "DELETE FROM CinemaCinemaBundle:Schedule s WHERE s.film_id= :id";
        $em = $this->getEntityManager();
        $query = $em->createQuery( $dql );
        $query->setParameters( array( 'id' => $id ));
        $result = $query->getResult();
        
        if ( file_exists( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_DIR . '/' . $name ) ) unlink( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_DIR . '/' . $name );
        if ( file_exists( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_BIG_DIR . '/' . $name ) ) unlink( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_BIG_DIR . '/' . $name );
        if ( file_exists( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_WALL_DIR . '/' . $name ) ) unlink( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_WALL_DIR . '/' . $name );
        foreach( $this->imageExtName as $ext )
        {
            $nameImageName = $id . '.' . $ext;
            if ( file_exists( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_NAME_DIR . '/' . $nameImageName ) ) unlink( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_NAME_DIR . '/' . $nameImageName );
        }
    }//end func
    
    
    /**
     * delete trailer file
     * for film with id
     * @param int $id Film id
     **/
    public function deleteTrailer( $id )
    {
        $film = $this->find( $id );
        $trailerUrl = $film->getTrailerLink();
        $filename = substr( $trailerUrl, strrpos( $trailerUrl, '/' ) + 1 );
        $filename = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::TRAILER_DIR . '/' . $filename;
        if ( file_exists( $filename ) && !is_dir( $filename )) unlink( $filename ); 
    }//end func
    
    
    /**
     * delete trailer file
     * for which the film does not exist
     * @return boolean false if fail
     **/
    public function deleteLostTrailres()
    {
        $films = $this->findAll();
        if ( !is_array( $films ) ) return false;
        $trailerNames = array();
        foreach( $films as $film )
        {
            $trailerUrl = $film->getTrailerLink();
            $trailerNames[] = substr( $trailerUrl, strrpos( $trailerUrl, '/' ) + 1 );  
        }
        $dirTrailrs = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::TRAILER_DIR;
        if ( !file_exists( $dirTrailrs) || !is_dir( $dirTrailrs )) return false;
        $filelist = scandir( $dirTrailrs );
        foreach( $filelist as $file )
        {
            if ( $file == '.' || $file == '..' ) continue;
            if ( !in_array( $file, $trailerNames ) )
            {
                $fullname = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::TRAILER_DIR . '/' . $file;
                if ( file_exists( $fullname ) && !is_dir( $fullname ) ) unlink( $fullname );
            }
        } 
    } //end func
    
    
    /**
     * delete poster, filmname  and wall images file
     * for which the film does not exist
     * @return boolean false if fail
     **/
    public function deleteLostPostersAndWall()
    {
        $films = $this->findAll();
        if ( !is_array( $films ) ) return false;
        $existsNames = array();
        $existsIds = array();
        foreach( $films as $film )
        {
            $existsNames[] = $film->getId() . CinemaCinemaBundle::IMG_EXT;
            $existsIds[] = $film->getId(); 
        } 
           
        $dirPoster = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_DIR;
        $dirPosterBig = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_BIG_DIR;
        $dirWall = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_WALL_DIR;
        $dirName = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_NAME_DIR;
        
        if ( file_exists( $dirPoster ) && is_dir( $dirPoster ))
        {
            $filelistPosterDir = scandir( $dirPoster );
            foreach( $filelistPosterDir as $file )
            {
                if ( $file == '.' || $file == '..' ) continue;
                if ( !in_array( $file, $existsNames ) )
                {
                    $fullname = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_DIR . '/' . $file;
                    if ( file_exists( $fullname ) && !is_dir( $fullname ) ) unlink( $fullname );
                }
            } 
        }
        
        if ( file_exists( $dirPosterBig ) && is_dir( $dirPosterBig ))
        {
            $filelistPosterDirBig = scandir( $dirPosterBig );
            foreach( $filelistPosterDirBig as $file )
            {
                if ( $file == '.' || $file == '..' ) continue;
                if ( !in_array( $file, $existsNames ) )
                {
                    $fullname = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_BIG_DIR . '/' . $file;
                    if ( file_exists( $fullname ) && !is_dir( $fullname ) ) unlink( $fullname );
                }
            } 
        }
        
        if ( file_exists( $dirWall ) && is_dir( $dirWall ))
        {
            $filelistWallDir = scandir( $dirWall );
            foreach( $filelistWallDir as $file )
            {
                if ( $file == '.' || $file == '..' ) continue;
                if ( !in_array( $file, $existsNames ) )
                {
                    $fullname = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_WALL_DIR . '/' . $file;
                    if ( file_exists( $fullname ) && !is_dir( $fullname ) ) unlink( $fullname );
                }
            } 
        }
        
        if ( file_exists( $dirName ) && is_dir( $dirName ))
        {
            $filelistNameDir = scandir( $dirName );
            foreach( $filelistNameDir as $file )
            {
                if ( $file == '.' || $file == '..' ) continue;
                $name = substr( $file, 0, strrpos( $file, '.' ) );
                if ( !in_array( $name, $existsIds ) )
                {
                    $fullname = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_NAME_DIR . '/' . $file;
                    if ( file_exists( $fullname ) && !is_dir( $fullname ) ) unlink( $fullname );
                }
            } 
        }
         
    } //end func
    
    /**
     * create array of genres for output in frontend 
     * @return array $genreAssoc Associative array of genres
     **/
    public function createGenreArray()
    {
        $this->setNames();
        $films = $this->findAll();
        $genreArray = array();
        $genreAssoc = array(); 
        if ( !$films ) return array();
        foreach( $films as $film )
        {
            $genresFilm = explode(',', $film->getGenre());
            if ( is_array( $genresFilm ) )
            {
                $added = 0;
                foreach( $genresFilm as $genreFilm ) 
                {
                    $genreFilm = trim($genreFilm);
                    if ( in_array( $genreFilm, $this->mainGenre ) )
                    {
                        $genreArray[] = $genreFilm;
                        $added++;
                    }
                }
                if ( $added == 0 ) $genreArray[] = $genresFilm[0];
            }
        }
        $genreArray = array_unique( $genreArray );
        foreach( $genreArray as $genre )
        {
            $key = $this->name2slug($genre);
            $genreAssoc[$key] = $genre;
        }
        return $genreAssoc;
    }//end func
    
    /**
     * write to database in field Film.onbackground false for all films  
     * @return boolean false if fail
     **/
    public function replaceBackground( $id )
    {
        $films = $this->findAll();
        if ( !$films ) return false;
        foreach( $films as $film ) $film->setOnbackground( false );
        
    }//end func
    
    
    /**
     * check wall image file exists for film with id 
     **/
    public function checkWall( $id )
    {
        
    }//end func
    
    /**
     * get film wallpaper is installed background site
     * @return object $film object Film 
     **/
    public function getFilmOnBackground()
    {
        $this->setNames();
        $film = $this->findOneBy( array( 'onbackground' => 1 ));
        if ( !$film ) return false;
        return $film;
        
    }//end func
    
    
    /**
     * create Film object from data obtained during parsing site
     * @param string $url Url to film on site(kinopoisk.ru)
     * @return object $film object Film 
     **/
    public function getFilmFromSite( $url )
    {
        $parser = new Parser();
        $filmInfo = $parser->parseAction( $url );
        if ( $filmInfo === false ) return false;           
        $film = new Film();
        $film->setAgelimit( $filmInfo['agelimit'] );
        $film->setCountry( $filmInfo['country']);
        $film->setDescription( $filmInfo['description']);
        $film->setDirector( $filmInfo['director']);
        $film->setGenre( $filmInfo['genre']);
        $film->setIs3d( $filmInfo['is3d']);
        $film->setName( $filmInfo['name'] );
        $slug = $this->name2slug( $filmInfo['name']);
        if ( $this->isSlugFree( $slug ) === false ) return false;
        $film->setSlug( $slug );
        $film->setYear( $filmInfo['year']);
        $film->setUrl($url);
        $film->setPosterBig( $filmInfo['poster_big'] );
        $film->setPosterSmall( $filmInfo['poster_small'] );
        $film->setDuration( $filmInfo['duration']);
        $film->setDateFirst( date_create( date( CinemaCinemaBundle::DATETIME_FORMAT, $filmInfo['date_first'] ) ) );
        $film->setDateLast( date_create( date( CinemaCinemaBundle::DATETIME_FORMAT, $filmInfo['date_last'] ) ) );
        $film->setDateFirstArena( date_create( date( CinemaCinemaBundle::DATETIME_FORMAT, $filmInfo['date_first'] ) ) );
        $film->setDateFirstWorld( date_create( date ( CinemaCinemaBundle::DATETIME_FORMAT, $filmInfo['date_first_world'] ) ) );
        $film->setBudget( $filmInfo['budget'] );
        $trailerUrl = ( strrpos( $url, '/' ) !== ( strlen($url) - 1 ) )? $url .= '/video/' : $url .= 'video/';
        $film->setTrailerLink( $trailerUrl );
        $film->setRating( $filmInfo['rating'] );
        $film->setNameEn( $filmInfo['name_en']);
        $film->setWallPresent( $filmInfo['wall_present']);
        $film->setWallUrl( $filmInfo['wall_url']);
        
        return $film;
    }//end func
    
    
    /**
     * create Film object from data obtained during form filling
     * @param array $post $_POST array
     * @return object $film object Film 
     **/
    public function getFilmFromForm( $post )
    {
        $film = new Film();
        $film->setAgelimit( intval( $post['agelimit'] ) );
        $film->setCountry( $post['country'] );
        $film->setDescription( $post['description'] );
        $film->setDirector( $post['director'] );
        $film->setGenre( $post['genre'] );
        $film->setIs3d( ( isset( $post['is3d'] ) )? true : false );
        $film->setName( $post['name'] );
        $slug = $this->name2slug( $post['name']);
        if ( $this->isSlugFree( $slug ) === false ) return false;
        $film->setSlug( $slug );
        $film->setYear( intval( $post['year' ] ) );
        $film->setUrl( $post['url'] );
        $film->setPosterBig( $post['poster_big'] );
        $film->setPosterSmall( $post['poster_small'] ); 
        $film->setDuration( $post['duration'] );
        $film->setDateFirst( date_create( date ( CinemaCinemaBundle::DATETIME_FORMAT, intval( $post['date_first'] ) ) ) );
        $film->setDateLast( date_create( date ( CinemaCinemaBundle::DATETIME_FORMAT, intval( $post['date_last'] ) ) ) );
        $film->setDateFirstArena( date_create( date ( CinemaCinemaBundle::DATETIME_FORMAT, intval( $post['date_first_arena'] ) ) ) );
        $film->setDateFirstWorld( date_create( date ( CinemaCinemaBundle::DATETIME_FORMAT, intval( $post['date_first_world'] ) ) ) );
        $film->setBudget( intval( $post['budget'] ) );
        $film->setTrailerLink( $post['trailer_link'] );
        $film->setRating( $post['rating'] );
        $film->setNameEn( $post['name_en'] );
        $film->setWallPresent( false );
        $film->setWallUrl( $post['wall_url'] );
    
        return $film;
    }//end func
    
    
    /**
     * check that given url to film is correct
     * @param string $url Url to film on site(kinopoisk.ru)
     * @return boolean true if correct false if not correct 
     **/
    public function checkUrl( $url )
    {
        $arr = array();
        if ( preg_match( CinemaCinemaBundle::REG_EXP_URL, $url, $arr ) == 1 ) return true;
        return false;
    }//end func
    
    
    /**
     * download posters and wall image file for film 
     * @param int $id Film id
     * @param object $film object Film
     * @return object $film object Film 
     **/
    public function loadImages( $id, Film $film )
    {
        $parser = new Parser();
        if ($parser->loadWallImage($film->getWallUrl(), $id)) $film->setWallPresent(true);
            else $film->setWallPresent(false);
        if ( $this->getWallImageName() ) $film->setWallPresent(true);
        $parser->loadBigImage( $film->getPosterBig(), $id );
        $parser->loadImage( $film->getPosterSmall(), $id );
        return $film;
    }//end func
    
    
    /**
     * download trailer file for film 
     * @param string $url Url to trailer page
     * @param int $id Film id
     * @return string $filename Name of trailer file 
     **/
    public function loadTrailer( $url, $id )
    {
        $parser = new Parser();
        $trailerUrl = $parser->getTrailerUrl( $url );
        if ( !$trailerUrl ) return false;
   		$filename = $parser->loadTrailer( $trailerUrl );
        if ( !$filename ) return false;
        $trailerLink = CinemaCinemaBundle::FILM_TRAILER_URL . $filename;
        $em = $this->getEntityManager();
        $film = $this->find( $id );
        $em->persist( $film );
        $film->setTrailerLink( $trailerLink );
        $em->flush();
        return $filename;  					
    }//end func
    
    
    /**
     * execute SQL query to database for set encoding 
     **/
    public function setNames()
    {
        $sql = CinemaCinemaBundle::NAMES;
        $conn = $this->getEntityManager()->getConnection();
        $conn->executeQuery($sql);
    }//end func
      
    /**
     * check extension of image file
     * @return boolean true if ok false if fail
     **/
    private function checkExt($filename, $extensions)
    {
        $ext = substr( $filename, strrpos( $filename, '.' ) + 1 );
        return in_array( $ext, $extensions );
    }//end func
    
    
    /**
     * upload wall image file from disk
     * @param int $id Film id
     * @return boolean true if ok false if fail
     **/
    public function uploadImageWall($id )
    {
        if ( isset( $_FILES['page_image'] ) )
    	{
    		$this->deleteImageWall($id);
            $folder = CinemaCinemaBundle::IMG_WALL_DIR;
            $dir = CinemaCinemaBundle::BASE_PATH . $folder;
            if ( !file_exists( $dir ) || !is_dir( $dir ) ) mkdir( $dir );
            $file = $_FILES['page_image'];
    		$name = $file['name'];
            if ( !$this->checkExt( $name, $this->imageExtWall) ) return false;
            $ext = substr( $name, strrpos( $name, '.' ) + 1 );
            $name = $id . '.' . $ext;
    		$savename = $dir . '/' . $name;
    		$tmpname = $file['tmp_name'];
    		if ( move_uploaded_file( $tmpname, $savename ) )
    		{
    			$film = $this->find($id);
                $em = $this->getEntityManager();
                $em->persist($film);
                $film->setWallPresent(true);
                $film->setWallUrl('');
                $em->flush();
                return true;
    		}
    		else
    		{
    			return false;;
    		}	
    	} 
    }//end func
    
    
    /**
     * delete film name image file
     * @param int $id Film id
     **/
    public function deleteImageName($id)
    {
        foreach( $this->imageExtName as $ext )
        {
            $nameImageName = $id . '.' . $ext;
            if ( file_exists( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_NAME_DIR . '/' . $nameImageName ) ) unlink( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_NAME_DIR . '/' . $nameImageName );
        }
    }//end func
    
    /**
     * delete film wall image file
     * @param int $id Film id
     **/
    public function deleteImageWall($id)
    {
        foreach( $this->imageExtWall as $ext )
        {
            $nameImageWall = $id . '.' . $ext;
            if ( file_exists( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_WALL_DIR . '/' . $nameImageWall ) ) unlink( CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_WALL_DIR . '/' . $nameImageWall );
        }
    }//end func
    
    
    /**
     * upload film name image file
     * @param int $id Film id
     * @return boolean true if ok false if fail
     **/
    public function uploadImageName($id)
    {
        if ( isset( $_FILES['page_image'] ) )
    	{
    		$this->deleteImageName($id);
            $folder = CinemaCinemaBundle::IMG_NAME_DIR;
            $dir = CinemaCinemaBundle::BASE_PATH . $folder;
            if ( !file_exists( $dir ) || !is_dir( $dir ) ) mkdir( $dir );
            $file = $_FILES['page_image'];
    		$name = $file['name'];
            $ext = substr( $name, strrpos( $name, '.' ) + 1 );
            if ( !$this->checkExt( $name, $this->imageExtName) ) return false;
            $name = $id . '.' . $ext;
    		$savename = $dir . '/' . $name;
    		$tmpname = $file['tmp_name'];
    		if ( move_uploaded_file( $tmpname, $savename ) )
    		{
    			return true;
    		}
    		else
    		{
    			return false;;
    		}	
    	} 
    }//end func
    
    
    /**
     * get image file name for the film which set background wallpaper site
     * @return string $file File name or false if fail
     **/
    public function getFilmImageName()
    {
        $film = $this->getFilmOnBackground();
        if ( !$film ) return false;
        $id = $film->getId();
        $folder = CinemaCinemaBundle::IMG_NAME_DIR;
        $dir = CinemaCinemaBundle::BASE_PATH . $folder;
        if ( file_exists( $dir ) && is_dir( $dir ) )
        {
            $files = scandir( $dir );
            foreach ( $files as $file )
            {
                if ( $file == '.' || $file == '..' ) continue;
                foreach ( $this->imageExtName as $ext )
                {
                    if ( $file == strval( $id . '.' . $ext ) ) return $file;
                }
            }
        }
        return false;
    }//end func
    
    
    /**
     * get image file wall for the film which set background wallpaper site
     * @return string $file File name or false if fail
     **/
    public function getWallImageName()
    {
        $film = $this->getFilmOnBackground();
        if ( !$film ) return false;
        $id = $film->getId();
        $folder = CinemaCinemaBundle::IMG_WALL_DIR;
        $dir = CinemaCinemaBundle::BASE_PATH . $folder;
        if ( file_exists( $dir ) && is_dir( $dir ) )
        {
            $files = scandir( $dir );
            foreach ( $files as $file )
            {
                if ( $file == '.' || $file == '..' ) continue;
                foreach ( $this->imageExtWall as $ext )
                {
                    if ( $file == strval( $id . '.' . $ext ) ) return $file;
                }
            }
        }
        return false;
    }//end func
}
