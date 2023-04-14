<?php

namespace Cinema\CinemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 */
class Schedule
{
    /**
     * @var integer
     */
    private $film_id;

    /**
     * @var \DateTime
     */
    private $time_begin;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var integer
     */
    private $numberRoot;


    /**
     * Set film_id
     *
     * @param integer $filmId
     * @return Schedule
     */
    public function setFilmId($filmId)
    {
        $this->film_id = $filmId;

        return $this;
    }

    /**
     * Get film_id
     *
     * @return integer 
     */
    public function getFilmId()
    {
        return $this->film_id;
    }

    /**
     * Set time_begin
     *
     * @param \DateTime $timeBegin
     * @return Schedule
     */
    public function setTimeBegin($timeBegin)
    {
        $this->time_begin = $timeBegin;

        return $this;
    }

    /**
     * Get time_begin
     *
     * @return \DateTime 
     */
    public function getTimeBegin()
    {
        return $this->time_begin;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Schedule
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set numberRoot
     *
     * @param integer $numberRoot
     * @return Schedule
     */
    public function setNumberRoot($numberRoot)
    {
        $this->numberRoot = $numberRoot;

        return $this;
    }

    /**
     * Get numberRoot
     *
     * @return integer 
     */
    public function getNumberRoot()
    {
        return $this->numberRoot;
    }
    /**
     * @var \Cinema\CinemaBundle\Entity\Film
     */
    private $film;


    /**
     * Set film
     *
     * @param \Cinema\CinemaBundle\Entity\Film $film
     * @return Schedule
     */
    public function setFilm(\Cinema\CinemaBundle\Entity\Film $film = null)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return \Cinema\CinemaBundle\Entity\Film 
     */
    public function getFilm()
    {
        return $this->film;
    }
    /**
     * @var integer
     */
    private $id;


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
     * @var integer
     */
    private $number_room;


    /**
     * Set number_room
     *
     * @param integer $numberRoom
     * @return Schedule
     */
    public function setNumberRoom($numberRoom)
    {
        $this->number_room = $numberRoom;

        return $this;
    }

    /**
     * Get number_room
     *
     * @return integer 
     */
    public function getNumberRoom()
    {
        return $this->number_room;
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
     * @return Schedule
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
     * @return Schedule
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
     * @var boolean
     */
    private $is3d;


    /**
     * Set is3d
     *
     * @param boolean $is3d
     * @return Schedule
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
}
