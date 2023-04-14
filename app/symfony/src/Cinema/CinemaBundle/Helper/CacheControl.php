<?php

namespace Cinema\CinemaBundle\Helper;
use Cinema\CinemaBundle\Helper\Setting;


class CacheControl
{
    
    public static function cacheCheck($doctrine, $request, $response, $entities=array(), $sharedEntities=array() )
    {
        foreach ( $sharedEntities as $entity ) $entities[]=$entity;
        $lastModified = self::getLastModified( $entities, $doctrine );
        $eTag = self::computeETag($entities,$doctrine);
        $response->setLastModified( $lastModified );
        $response->setEtag($eTag);
        return ( $response->isNotModified($request) )? 
            self::setCacheHeaders( $request, $response, $lastModified, $eTag ) : 
            array('lastmodified'=>$lastModified,'etag'=>$eTag);
    }//end func
    
    
    /**
     * get LastModified DateTime
     * @param array $entities an array of strings representing the names of entities
     * @return DateTime $lastModified  Time last modified entities
     **/
    public static function getLastModified($entities = array(), $doctrine)
    {
        
        $lastModified = new \DateTime( '1970-01-01 00:00:00' );
        foreach( $entities as $entity )
        {
            $lastModifiedEntity = self::getLastModifiedEntity($entity,$doctrine);
            if ( $lastModifiedEntity > $lastModified ) $lastModified = $lastModifiedEntity;
        }
        return $lastModified;
    }//end func
    
    /**
     * set Response headers
     * @param object Response $response object Response
     * @param DateTime $lastModified Last modified entities
     * @param string $eTag E-tag
     * @return object Response $response object Response
     **/
    public static function setCacheHeaders( $request, $response, $lastModified, $eTag )
    {
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->setLastModified( $lastModified );
        $response->isNotModified($request);
        $response->setMaxAge(Setting::MAXAGE);
        $response->setSharedMaxAge(Setting::MAXAGE);
        $response->setETag($eTag);
        $date = new \DateTime();
        $date->modify(Setting::EXPIRES);
        $response->setExpires($date);
        return $response;
    }//end func
    
    /**
     * compute E-Tag
     * @param array $entities an array of strings representing the names of entities
     * @return string $eTag E-Tag 
     **/
    public static function computeETag( $entities = array(), $doctrine)
    {
        $eTag = '';
        foreach( $entities as $entity )
        {
            $eTag .= self::computeETagEntity( $entity, $doctrine );
        }
        return $eTag;
    }//end func
    
    /**
     * get date and time last modified entity
     * @return object DateTime
     **/
    public static function getLastModifiedEntity($entity, $doctrine )
    {
        $lastModified = new \DateTime( '1970-01-01 00:00:00' );
        $em = $doctrine->getManager();
        $dql = 'SELECT MAX(e.updated_at) FROM '.Setting::BUNDLE.':'. $entity .' e';
        $query = $em->createQuery($dql);
        $dateStr = $query->getSingleScalarResult();
        $lastUpdate = ($dateStr)? date_create($dateStr) : $lastModified;
        
        $dql = 'SELECT MAX(e.created_at) FROM '.Setting::BUNDLE.':'. $entity .' e';
        $query = $em->createQuery($dql);
        $dateStr = $query->getSingleScalarResult();
        $lastCreate = ($dateStr)? date_create($dateStr) : $lastModified;
               
        return  ( $lastUpdate > $lastCreate )?  $lastUpdate : $lastCreate;
    }//end func
    
    
    /**
     * get E-Tag for entity
     * @return string E-Tag
     **/
    public static function computeETagEntity($entity, $doctrine)
    {
        $em = $doctrine->getManager();
        $dql = 'SELECT COUNT(e.id) FROM '.Setting::BUNDLE.':'. $entity .' e';
        $query = $em->createQuery($dql);
        $count = intval($query->getSingleScalarResult());
        return md5($count . date('d',time()));
    }//end func 
    
}//end class