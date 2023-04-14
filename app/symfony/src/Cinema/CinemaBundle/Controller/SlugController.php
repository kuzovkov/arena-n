<?php

namespace Cinema\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Cinema\CinemaBundle\CinemaCinemaBundle;
use Cinema\CinemaBundle\Helper\Setting;
use Cinema\CinemaBundle\Helper\CacheControl;

class SlugController extends Controller
{   
    
    protected $sharedEntities = array();
    /**
     * Controller for /{slug} router
     * @param string $slug Slug of page
     **/
    public function slugAction( $slug = 'index' )
    {
        $entities = array('Film', 'Page');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $repository->setNames();
        $pageRepo = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Page");
        $page = $pageRepo->findOneBy( array( 'slug' => $slug, 'type' => 'CINEMA' ));
        $data['filmbackground'] = $repository->getFilmOnBackground();
        $data['filmnameimage'] = $repository->getFilmImageName();
        if ( !$page )
        {
            throw $this->createNotFoundException( 'Page not found: ' . $slug );
        }
        $data['snipets'] = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Snipet")->getAllSnipets();
        $response = $this->render('CinemaCinemaBundle:Default:layout.html.twig', array( 'page'=> $page, 'data' => $data ));
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
    
    /**
     * Controller for /retrobar/{slug} router
     * @param string $slug Slug of page
     **/
    public function retrobarslugAction( $slug = 'index' )
    {
        $entities = array('Film', 'Page');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $repository->setNames();
        $pageRepo = $this->getDoctrine()->getRepository( 'CinemaCinemaBundle:Page' );
        $page = $pageRepo->findOneBy( array( 'slug' => $slug, 'type' => 'RETROBAR' ));
        $data['filmbackground'] = $repository->getFilmOnBackground();
        $data['slug'] = $slug;
        if ( !$page )
        {
            throw $this->createNotFoundException( 'Page not found: ' . $slug );
        }
        $data['snipets'] = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Snipet")->getAllSnipets();
        $response = $this->render('CinemaCinemaBundle:Retrobar:layout.html.twig', array( 'page'=> $page, 'data' => $data ));
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
    
}