<?php

namespace Cinema\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Cinema\CinemaBundle\CinemaCinemaBundle;
use Cinema\CinemaBundle\Helper\Setting;
use Cinema\CinemaBundle\Helper\CacheControl;

class RetrobarController extends Controller
{
    protected $month = array( 'января', 'февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря' );
    protected $sharedEntities = array();
    /**
     * Controller for /retrobar router
     **/
    public function indexAction()
    {
        $entities = array('Film', 'News');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $repository->setNames();
        $repoNews = $this->getDoctrine()->getRepository("CinemaCinemaBundle:News");
        $data['rb_news'] = $repoNews->getNews('RB_NEWS');
        $data['rb_action'] = $repoNews->getNews('RB_ACTION');
        $data['rb_activity'] = $repoNews->getNews('RB_ACTIVITY', 0, 4 );
        $data['month'] = $this->month;
        $response = $this->render( 'CinemaCinemaBundle:Retrobar:retrobar.html.twig', array('data'=>$data) );
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func 
      
}