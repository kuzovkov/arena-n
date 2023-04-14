<?php

namespace Cinema\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Cinema\CinemaBundle\CinemaCinemaBundle;
use Cinema\CinemaBundle\Helper\Setting;
use Cinema\CinemaBundle\Helper\CacheControl;

class NewsController extends Controller
{
    protected $month = array( 'января', 'февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря' );
    protected $sharedEntities = array();
    /**
     * Controller for /news/page/{page} router
     * @param int $page Number of page
     **/
    public function allNewsAction($page=1)
    {
        $entities = array('Film', 'News', 'Snipet');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $data['filmbackground'] = $repository->getFilmOnBackground();
        $data['filmnameimage'] = $repository->getFilmImageName();
        $repoNews = $this->getDoctrine()->getRepository("CinemaCinemaBundle:News");
        $data['news'] = $repoNews->getNewsPage('CINEMA_NEWS', $page);
        $data['pages'] = $repoNews->getNumberPage('CINEMA_NEWS');
        $data['page'] = $page;
        $data['month'] = $this->month;
        $data['snipets'] = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Snipet")->getAllSnipets();
        $response = $this->render( 'CinemaCinemaBundle:Default:all_news.html.twig', array('data'=>$data));
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
        
    }//end func
    
    /**
     * Controller for /news/{id} router
     * @param int $page Number of news
     **/
    public function oneNewsAction($id=null)
    {
        $entities = array('Film', 'News', 'Snipet');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $data['filmbackground'] = $repository->getFilmOnBackground();
        $data['filmnameimage'] = $repository->getFilmImageName();
        $repoNews = $this->getDoctrine()->getRepository("CinemaCinemaBundle:News");
        $data['news'] = $repoNews->getOneNews($id);
        $data['month'] = $this->month;
        $data['snipets'] = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Snipet")->getAllSnipets();
        $response = $this->render( 'CinemaCinemaBundle:Default:one_news.html.twig', array('data'=>$data));
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
    
    /**
     * Controller for /retrobar/news/{id} router
     * @param int $page Number of news
     **/
    public function oneNewsRbAction($id=null)
    {
        $entities = array('Film', 'News', 'Snipet');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        
        $types = array( 'RB_NEWS' => 'news', 'RB_ACTION' => 'action', 'RB_ACTIVITY' => 'activity' );
        $title = array( 'RB_NEWS' => 'новости', 'RB_ACTION' => 'акции', 'RB_ACTIVITY' => 'мероприятия' );
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $repository->setNames();
        $repoNews = $this->getDoctrine()->getRepository("CinemaCinemaBundle:News");
        $news = $repoNews->getOneNews($id);
        $data['news'] = $news;
        $data['month'] = $this->month;
        $data['type'] = $types[$news->getType()];
        $data['title'] = $title[$news->getType()];
        $data['snipets'] = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Snipet")->getAllSnipets();
        $response = $this->render( 'CinemaCinemaBundle:Retrobar:one_news.html.twig', array('data'=>$data));
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
    
    /**
     * Controller for /retrobar/news/page/{page} router
     * @param string  $type Type of news
     * @param int $page Number of page
     **/
    public function allNewsRbAction( $type, $page=1)
    {
        $entities = array('Film', 'News', 'Snipet');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        
        $types = array( 'news' => 'RB_NEWS', 'action' => 'RB_ACTION', 'activity' => 'RB_ACTIVITY' );
        $title = array( 'news' => 'Новости', 'action' => 'Акции', 'activity' => 'Мероприятия' );
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $repository->setNames();
        $repoNews = $this->getDoctrine()->getRepository("CinemaCinemaBundle:News");
        $data['news'] = $repoNews->getNewsPage($types[$type], $page);
        $data['pages'] = $repoNews->getNumberPage($types[$type]);
        $data['page'] = $page;
        $data['title'] = $title[$type];
        $data['type'] = $type;
        $data['month'] = $this->month;
        $data['snipets'] = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Snipet")->getAllSnipets();
        $response = $this->render( 'CinemaCinemaBundle:Retrobar:all_news.html.twig', array('data'=>$data));
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
    
}