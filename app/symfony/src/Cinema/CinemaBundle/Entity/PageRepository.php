<?php

namespace Cinema\CinemaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Cinema\CinemaBundle\CinemaCinemaBundle;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository
{   
    /**
     * Array extensions for images files added into page   
     **/
    
    protected $imageExt = array( 'jpg', 'jpeg', 'png', 'gif', 'bmp' );
    
    
    /**
     * get list image file for insert into MCETiny editor
     * @return array $files Associative array of files or false if fail
     **/
    public function getListImage()
    {
        $dir = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::PAGE_IMG_DIR;
        if ( !file_exists( $dir ) || !is_dir( $dir ) ) mkdir( $dir );
        $list = scandir( $dir );
        if (!$list) return false;
        if (is_array($list))
        {
            $files = array();
            foreach( $list as $item )
            {
                if( !is_dir( $dir . '/' . $item ) )
                    if( $this->checkExt( $item, $this->imageExt ) )
                        $files[$item] = CinemaCinemaBundle::PAGE_IMG_URL . $item;
            }
            return $files;
        }
        return false;
    }//end func
    
    
    
    /**
     * check extension of image file
     * @param string $filename File name
     * @param array $extensions Array of extensions
     * @return boolean true if extensions Ok or false otherwise
     **/
    private function checkExt($filename, $extensions)
    {
        $ext = substr( $filename, strrpos( $filename, '.' ) + 1 );
        return in_array( $ext, $extensions );
    }//end func
    
    
    /**
     * upload Image for insert into page
     * @return boolean true if upload success or false otherwise
     **/
    public function uploadImage()
    {
        if ( isset( $_FILES['page_image'] ) )
    	{
    		$dir = CinemaCinemaBundle::BASE_PATH . CinemaCinemaBundle::PAGE_IMG_DIR;
            if ( !file_exists( $dir ) || !is_dir( $dir ) ) mkdir( $dir );
            $file = $_FILES['page_image'];
    		$name = $file['name'];
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
}
