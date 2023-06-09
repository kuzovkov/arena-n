<?php

namespace Cinema\CinemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cinema\CinemaBundle\CinemaCinemaBundle;

/**
 * Banner
 */
class Banner
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $show;

    /**
     * @var string
     */
    private $imgfilename;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;


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
     * Set name
     *
     * @param string $name
     * @return Banner
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
     * Set show
     *
     * @param boolean $show
     * @return Banner
     */
    public function setShow($show)
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Get show
     *
     * @return boolean 
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * Set imgfilename
     *
     * @param string $imgfilename
     * @return Banner
     */
    public function setImgfilename($imgfilename)
    {
        $this->imgfilename = $imgfilename;

        return $this;
    }

    /**
     * Get imgfilename
     *
     * @return string 
     */
    public function getImgfilename()
    {
        return $this->imgfilename;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Banner
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
     * @return Banner
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
    
    public function __toString()
    {
        return $this->getId() ? strval($this->getId()) : '-';
    }
    /**
     * @var boolean
     */
    private $bannershow;


    /**
     * Set bannershow
     *
     * @param boolean $bannershow
     * @return Banner
     */
    public function setBannershow($bannershow)
    {
        $this->bannershow = $bannershow;

        return $this;
    }

    /**
     * Get bannershow
     *
     * @return boolean 
     */
    public function getBannershow()
    {
        return $this->bannershow;
    }
    
    public function getBannerImageUrl()
    {
        if ( !$this->imgfilename ) return false;
        //return CinemaCinemaBundle::BASE_URL . CinemaCinemaBundle::BANNER_URL . $this->imgfilename;
    	return '/' . CinemaCinemaBundle::BANNER_URL . $this->imgfilename;
    }
    /**
     * @var string
     */
    private $banner_url;


    /**
     * Set banner_url
     *
     * @param string $bannerUrl
     * @return Banner
     */
    public function setBannerUrl($bannerUrl)
    {
        $this->banner_url = $bannerUrl;

        return $this;
    }

    /**
     * Get banner_url
     *
     * @return string 
     */
    public function getBannerUrl()
    {
        return $this->banner_url;
    }
}
