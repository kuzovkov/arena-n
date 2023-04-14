<?php

namespace Cinema\CinemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cinema\CinemaBundle\CinemaCinemaBundle;

/**
 * Film
 */
class Film
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name_ru;

    /**
     * @var string
     */
    private $name_en;

    /**
     * @var string
     */
    private $country;

    /**
     * @var integer
     */
    private $year;

    /**
     * @var string
     */
    private $slogan;

    /**
     * @var string
     */
    private $director;

    /**
     * @var string
     */
    private $genre;

    /**
     * @var boolean
     */
    private $is3d;

    /**
     * @var integer
     */
    private $agelimit;

    /**
     * @var string
     */
    private $poster_big;

    /**
     * @var string
     */
    private $poster_small;

    /**
     * @var string
     */
    private $url;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name_ru
     *
     * @param string $nameRu
     * @return Film
     */
    public function setNameRu($nameRu)
    {
        $this->name_ru = $nameRu;

        return $this;
    }

    /**
     * Get name_ru
     *
     * @return string 
     */
    public function getNameRu()
    {
        return $this->name_ru;
    }

    /**
     * Set name_en
     *
     * @param string $nameEn
     * @return Film
     */
    public function setNameEn($nameEn)
    {
        $this->name_en = $nameEn;

        return $this;
    }

    /**
     * Get name_en
     *
     * @return string 
     */
    public function getNameEn()
    {
        return $this->name_en;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Film
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Film
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     * @return Film
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * Get slogan
     *
     * @return string 
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set director
     *
     * @param string $director
     * @return Film
     */
    public function setDirector($director)
    {
        $this->director = $director;

        return $this;
    }

    /**
     * Get director
     *
     * @return string 
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set genre
     *
     * @param string $genre
     * @return Film
     */
    public function setGenre($genre)
    {
        $this->genre = trim($genre);

        return $this;
    }

    /**
     * Get genre
     *
     * @return string 
     */
    public function getGenre()
    {
        return (substr($this->genre, -1) == ',')? substr( $this->genre, 0, strlen( $this->genre )-1 ) : $this->genre;
    }

    /**
     * Set is3d
     *
     * @param boolean $is3d
     * @return Film
     */
    public function setIs3d($is3d)
    {
        $this->is3d = $is3d;

        return $this;
    }

    /**
     * Get is3d
     *
     * @return boolean 
     */
    public function getIs3d()
    {
        return $this->is3d;
    }

    /**
     * Set agelimit
     *
     * @param integer $agelimit
     * @return Film
     */
    public function setAgelimit($agelimit)
    {
        $this->agelimit = $agelimit;

        return $this;
    }

    /**
     * Get agelimit
     *
     * @return integer 
     */
    public function getAgelimit()
    {
        return $this->agelimit;
    }

    /**
     * Set poster_big
     *
     * @param string $posterBig
     * @return Film
     */
    public function setPosterBig($posterBig)
    {
        $this->poster_big = $posterBig;

        return $this;
    }

    /**
     * Get poster_big
     *
     * @return string 
     */
    public function getPosterBig()
    {
        return $this->poster_big;
    }

    /**
     * Set poster_small
     *
     * @param string $posterSmall
     * @return Film
     */
    public function setPosterSmall($posterSmall)
    {
        $this->poster_small = $posterSmall;

        return $this;
    }

    /**
     * Get poster_small
     *
     * @return string 
     */
    public function getPosterSmall()
    {
        return $this->poster_small;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Film
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

   
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     * @return Film
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return Film
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var integer
     */
    private $duration;

    /**
     * @var string
     */
    private $date_first;

    /**
     * @var string
     */
    private $date_last;


    /**
     * Set duration
     *
     * @param integer $duration
     * @return Film
     */
    public function setDuration($duration)
    {
        if ( !is_numeric( $duration ) )
        {
            $duration = $this->convertDuration( $duration );
        }
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        if ( $this->duration == 0 ) return null;
        $dur = $this->duration;
        return (( $dur - $dur % 60 ) / 60 ) . ' ч ' . ( $dur % 60 ) . ' мин';
    }
    
    public function getRawDuration()
    {
        return $this->duration;
    }

    /**
     * Set date_first
     *
     * @param string $dateFirst
     * @return Film
     */
    public function setDateFirst($dateFirst)
    {
        $this->date_first = $dateFirst;

        return $this;
    }

    /**
     * Get date_first
     *
     * @return string 
     */
    public function getDateFirst()
    {
        return $this->date_first;
    }

    /**
     * Set date_last
     *
     * @param string $dateLast
     * @return Film
     */
    public function setDateLast($dateLast)
    {
        $this->date_last = $dateLast;

        return $this;
    }

    /**
     * Get date_last
     *
     * @return string 
     */
    public function getDateLast()
    {
        return $this->date_last;
    }
    
    
    /**
     * Convert duration from "1h 20 min" to 140
     *
     * @return integer 
     */
    private function convertDuration( $inputStr )
    {
        $len = strlen( $inputStr );
        $str = '';
        for ( $i = 0; $i < $len; $i++ )
        {
            $code = ord( $inputStr{$i} );
            if ( ( $code >= 0x30 && $code <= 0x39 ) || $code == 0x20 )
            {
                $str .= $inputStr{$i};
            }
        }
        $array = explode( ' ', $str );
        $time = array();
        foreach( $array as $item )
        {
            $item = trim( $item );
            if ( !empty( $item ) )
            {
                $time[] = $item;
            }
            
        }
        if ( count( $time ) < 2 ) return false;
        return intval( $time[0] ) * 60 + intval( $time[1] );
    }
    
    public function __toString()
    {
        return $this->getId() ? strval($this->getId()) : '-';
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $schedules;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schedules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add schedules
     *
     * @param \Cinema\CinemaBundle\Entity\Schedule $schedules
     * @return Film
     */
    public function addSchedule(\Cinema\CinemaBundle\Entity\Schedule $schedules)
    {
        $this->schedules[] = $schedules;

        return $this;
    }

    /**
     * Remove schedules
     *
     * @param \Cinema\CinemaBundle\Entity\Schedule $schedules
     */
    public function removeSchedule(\Cinema\CinemaBundle\Entity\Schedule $schedules)
    {
        $this->schedules->removeElement($schedules);
    }

    /**
     * Get schedules
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchedules()
    {
        return $this->schedules;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $schedule;


    /**
     * Get schedule
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchedule()
    {
        return $this->schedule;
    }
    /**
     * @var \DateTime
     */
    private $date_first_world;

    /**
     * @var \DateTime
     */
    private $date_first_arena;

    /**
     * @var integer
     */
    private $budget;

    /**
     * @var string
     */
    private $trailer_link;


    /**
     * Set date_first_world
     *
     * @param \DateTime $dateFirstWorld
     * @return Film
     */
    public function setDateFirstWorld($dateFirstWorld)
    {
        $this->date_first_world = $dateFirstWorld;

        return $this;
    }

    /**
     * Get date_first_world
     *
     * @return \DateTime 
     */
    public function getDateFirstWorld()
    {
        return $this->date_first_world;
    }

    /**
     * Set date_first_arena
     *
     * @param \DateTime $dateFirstArena
     * @return Film
     */
    public function setDateFirstArena($dateFirstArena)
    {
        $this->date_first_arena = $dateFirstArena;

        return $this;
    }

    /**
     * Get date_first_arena
     *
     * @return \DateTime 
     */
    public function getDateFirstArena()
    {
        
        return $this->date_first_arena;
    }

    /**
     * Set budget
     *
     * @param integer $budget
     * @return Film
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return integer 
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set trailer_link
     *
     * @param string $trailerLink
     * @return Film
     */
    public function setTrailerLink($trailerLink)
    {
        $this->trailer_link = $this->convertTrailerLink( $trailerLink );

        return $this;
    }

    /**
     * Get trailer_link
     *
     * @return string 
     */
    public function getTrailerLink()
    {
        return $this->trailer_link;
    }
    /**
     * @var string
     */
    private $rating;


    /**
     * Set rating
     *
     * @param string $rating
     * @return Film
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return string 
     */
    public function getRating()
    {
        return $this->rating;
    }
    /**
     * @var string
     */
    private $slug;


    /**
     * Set slug
     *
     * @param string $slug
     * @return Film
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * @var boolean
     */
    private $onbackground;


    /**
     * Set onbackground
     *
     * @param boolean $onbackground
     * @return Film
     */
    public function setOnbackground($onbackground)
    {
        $this->onbackground = $onbackground;

        return $this;
    }

    /**
     * Get onbackground
     *
     * @return boolean 
     */
    public function getOnbackground()
    {
        return $this->onbackground;
    }
    /**
     * @var boolean
     */
    private $wall_present;


    /**
     * Set wall_present
     *
     * @param boolean $wallPresent
     * @return Film
     */
    public function setWallPresent($wallPresent)
    {
        $this->wall_present = $wallPresent;

        return $this;
    }

    /**
     * Get wall_present
     *
     * @return boolean 
     */
    public function getWallPresent()
    {
        return $this->wall_present;
    }
    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Film
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Film
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
            $this->created_at = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = new \DateTime();
    }
    /**
     * @var string
     */
    private $wall_url;


    /**
     * Set wall_url
     *
     * @param string $wallUrl
     * @return Film
     */
    public function setWallUrl($wallUrl)
    {
        $this->wall_url = $wallUrl;

        return $this;
    }

    /**
     * Get wall_url
     *
     * @return string 
     */
    public function getWallUrl()
    {
        return $this->wall_url;
    }
    
    
    /**
     * Convert link to trailer 
     * @param string $link Link to trailer
     * @return string $link   
     **/
    private function convertTrailerLink( $link )
    {
        $pattern = '/http:\/\/www.youtube.com\/embed\/[0-9a-zA-Z-]{6,}/';
        $baseUrl = 'http://www.youtube.com/embed/';
        if ( preg_match( $pattern, $link ) ) return $link;
        $matches = array();
        $pattern2 = '/v=[0-9a-zA-Z-]{6,}/';
        preg_match( $pattern2, $link, $matches );
        if ( isset($matches[0]) ) return $baseUrl . substr( $matches[0], 2 );
        return $link; 
    }
    
    
    /**
     * get Url to file image name 
     * @return string $url Url to image name file or false if fail  
     **/
    public function getImageNameUrl()
    {
        $exts = array( 'jpg', 'jpeg', 'png' );
        $id = $this->getId();
        $url = CinemaCinemaBundle::BASE_URL . CinemaCinemaBundle::IMG_NAME_URL;
        $dir = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_NAME_DIR;
        foreach ( $exts as $ext )
        {
            if( file_exists( $dir . '/' . $id . '.' . $ext ) ) return $url . '/' . $id . '.' . $ext;
        }
        return false;
    }
    
    /**
     * get Url to file image wall 
     * @return $url string Url to image wall file or false if fail  
     **/
    public function getImageWallUrl()
    {
        $exts = array( 'jpg', 'jpeg', 'png' );
        $id = $this->getId();
        $url = CinemaCinemaBundle::BASE_URL . CinemaCinemaBundle::IMG_WALL_URL;
        $dir = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_WALL_DIR;
        foreach ( $exts as $ext )
        {
            if( file_exists( $dir . '/' . $id . '.' . $ext ) ) return $url . '/' . $id . '.' . $ext;
        }
        return false;
    }
    
    /**
     * get Url to file image wall 
     * @return $url string Url to image wall file or false if fail  
     **/
    public function getImageWallName()
    {
        $exts = array( 'jpg', 'jpeg', 'png' );
        $id = $this->getId();
        $dir = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::IMG_WALL_DIR;
        foreach ( $exts as $ext )
        {
            if( file_exists( $dir . '/' . $id . '.' . $ext ) ) return $id . '.' . $ext;
        }
        return false;
    }
    
    
    /**
     * @var \DateTime
     */
    private $end_key;

    /**
     * @var boolean
     */
    private $avail_key;

    /**
     * @var boolean
     */
    private $avail_film;


    /**
     * Set end_key
     *
     * @param \DateTime $endKey
     * @return Film
     */
    public function setEndKey($endKey)
    {
        $this->end_key = $endKey;

        return $this;
    }

    /**
     * Get end_key
     *
     * @return \DateTime 
     */
    public function getEndKey()
    {
        return $this->end_key;
    }

    /**
     * Set avail_key
     *
     * @param boolean $availKey
     * @return Film
     */
    public function setAvailKey($availKey)
    {
        $this->avail_key = $availKey;

        return $this;
    }

    /**
     * Get avail_key
     *
     * @return boolean 
     */
    public function getAvailKey()
    {
        return $this->avail_key;
    }

    /**
     * Set avail_film
     *
     * @param boolean $availFilm
     * @return Film
     */
    public function setAvailFilm($availFilm)
    {
        $this->avail_film = $availFilm;

        return $this;
    }

    /**
     * Get avail_film
     *
     * @return boolean 
     */
    public function getAvailFilm()
    {
        return $this->avail_film;
    }
    
    
    /**
     * Define text color for film list table in Admin palel 
     * depending on availability and date of license expiration 
     * @return string Hex-code of color
     **/
    public function defineColor()
    {
        $color = array( 'black' => '#000000',
                        'red' => '#FF0000',
                        'green' => '#0A6407',
                        'brown' => '#500000'
                        );
        if ( !$this->avail_key && !$this->avail_film ) return $color['black'];
        if ( !$this->avail_key && $this->avail_film ) return $color['red'];
        if ( $this->avail_key && $this->avail_film )
        {
             if (!$this->end_key) return $color['black'];
             $now = time();
             $endKey = $this->end_key;
             $keyTime = $endKey->getTimestamp();
             if ( $keyTime - $now < CinemaCinemaBundle::SEC_IN_DAY ) return $color['brown'];
             if ( $keyTime - $now < 0 ) return $color['red'];     
        }
        return $color['green'];
    }
    
    
    /**
     * Set date End of key to null in database if
     * Key is not exists 
     **/
    public function correctEndKey()
    {
        if ( !$this->avail_key ) $this->end_key = null;
    }
    
    
    /**
     * Check that wall image file present and set field wall_present
     **/
    public function checkWallPresent()
    {
        $imageExtWall = array( 'jpg', 'jpeg', 'png' );
        $id = $this->id;
        if ( !$id ) return false;
        $folder = CinemaCinemaBundle::IMG_WALL_DIR;
        $dir = CinemaCinemaBundle::BASE_PATH . $folder;
        $result = false;
        if ( file_exists( $dir ) && is_dir( $dir ) )
        {
            $files = scandir( $dir );
            foreach ( $files as $file )
            {
                if ( $file == '.' || $file == '..' ) continue;
                foreach ( $imageExtWall as $ext )
                {
                    if ( $file == strval( $id . '.' . $ext ) ) $result=true;
                }
            }
        }
        $this->wall_present = ($result)? true : false;  
    }
    
}
