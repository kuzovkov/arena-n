<?php

namespace Cinema\CinemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 */
class News
{
    const SERVER_PATH_TO_IMAGE_FOLDER = 'upload/images/news';
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var UploadedFile
     */
    public $img;
    

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $userId;


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
     * Set title
     *
     * @param string $title
     * @return News
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return News
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set img
     *
     * @param string $img
     * @return News
     */
    
    public function setImg($img=null)
    {
        if ($img == null ) return;
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return News
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return News
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }


    public function __toString()
    {
        return $this->getId() ? strval($this->getId()) : '-';
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {// Add your code here
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
     * @return News
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
     * @return News
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
    
    public function getUploadDir()
    {
        return News::SERVER_PATH_TO_IMAGE_FOLDER .'/';
    }
    
    /*
    public function upload()
    {
        if (null === $this->getImg()) {
            return;
        }
        if (!is_object($this->getImg())) return;
        //get original filename    
        $filename = $this->getImg()->getClientOriginalName();
        //extract extensio of file
        $ext = strrchr($filename, '.');
        $name = substr(md5( time() ), 20 ) . $ext;
        $this->getImg()->move(
            News::SERVER_PATH_TO_IMAGE_FOLDER,
            $name
        );
    
        // clean up the file property as you won't need it anymore
        $this->setImg($name);
    }//end func
    */
    /**
     * Lifecycle callback to upload the file to the server
     */
    
    
    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */

}
