<?php

namespace Cinema\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Cinema\CinemaBundle\CinemaCinemaBundle;
use Cinema\CinemaBundle\Helper\Setting;
use Cinema\CinemaBundle\Helper\CacheControl;

use Cinema\CinemaBundle\Controller\UserAdmin as S;

class DefaultController extends Controller
{
    
    protected $days = array( 'ВС','ПН','ВТ','СР','ЧТ','ПТ','СБ' );
    protected $days2 = array( 'Вс','Пн','Вт','Ср','Чт','Пт','Сб' );
    protected $month = array( 'января', 'февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря' );
    protected $sharedEntities = array();
    /**
     * Controller for / router
     * @param string $genre Genre of films
     **/
    
    public function indexAction( $genre = 'all' )
    {
	//var_dump(UserAdminController::encodePassword("admin", "")); die;
        $entities = array('Film', 'News', 'Schedule');
	
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        
        $repository = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Film");
        $repoNews = $this->getDoctrine()->getRepository(Setting::BUNDLE.":News");
        $data['genres'] = $repository->createGenreArray();
        $data['today'] = $repository->getFilmsTodayInfo( $genre );
        $data['soon'] = $repository->getFilmsSoonInfo($genre);
        $data['filmbackground'] = $repository->getFilmOnBackground();
        $data['filmnameimage'] = $repository->getFilmImageName();
        $data['news'] = $repoNews->getNews('CINEMA_NEWS');
        $data['month'] = $this->month;
        $response = $this->render( Setting::BUNDLE.':Default:index.html.twig', array( 'data'=> $data ) );
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
    
    /**
     * Controller for /today router
     * @param string $genre Genre of films
     **/
    public function todayAction( $genre='all' )
    {
        
        $entities = array('Film', 'Banner', 'Schedule');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        $repository = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Film");
        $repoBanners = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Banner");
        $data['today'] = $repository->getFilmsTodayInfo( $genre );
        $data['genres'] = $repository->createGenreArray();
        $data['filmbackground'] = $repository->getFilmOnBackground();
        $data['filmnameimage'] = $repository->getFilmImageName();
        $data['banners'] = $repoBanners->getBanners();
        $response = $this->render( Setting::BUNDLE.':Default:today.html.twig', array( 'data'=> $data ) );
        
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
    
    /**
     * Controller for /soon router
     * 
     **/
    public function soonAction()
    {
        $entities = array('Film', 'Banner', 'Schedule');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        $repository = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Film");
        $repoBanners = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Banner");
        $data['soon'] = $repository->getFilmsSoonInfo();
        $data['filmbackground'] = $repository->getFilmOnBackground();
        $data['filmnameimage'] = $repository->getFilmImageName();
        $data['banners'] = $repoBanners->getBanners();
        $response = $this->render( Setting::BUNDLE.':Default:soon.html.twig', array( 'data'=> $data ) );
        
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
    
    /**
     * Controller for /schedule router
     * 
     **/
    public function scheduleAction()
    {
        $entities = array('Film', 'Schedule');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        $repository = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Film");
        $data['filmbackground'] = $repository->getFilmOnBackground();
        $data['filmnameimage'] = $repository->getFilmImageName();
        $response = $this->render( Setting::BUNDLE.':Default:schedule.html.twig', array('data'=>$data));
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
    
    
    /**
     * Controller for AJAX query to get table schedule film on film page
     * 
     **/
    public function getScheduleTableAction()
    {
        $request = $this->get('request');
        $id = $request->request->get('id');
        $week = $request->request->get('week');
        $repoFilm = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Film");
        $film = $repoFilm->find($id);
        $is3d = ( $film )? $film->getIs3d() : false;
        $repository = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Schedule");
        $data = $repository->getScheduleTable( $id, $week );
        if ( is_array( $data ) ) return $this->render( Setting::BUNDLE.':Default:table_film_schedule.html.php', array( 'data' => $data, 'days' => $this->days2, 'is3d' => $is3d ) );
        return $this->render( Setting::BUNDLE.':Default:empty_schedule.html.php' );
    }//end func
    
    /**
     * Controller for AJAX query to get table schedule of all film
     * 
     **/
    public function getFullScheduleTableAction()
    {
        $request = $this->get('request');
        $day = $request->request->get('day');
        $repository = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Schedule");
        $repositoryFilm = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Film");
        $films = $repositoryFilm->getFilms();
        $data = $repository->getFullScheduleTable2( $day, $films );
        //print_r($data); exit();
        $areSeanceTomorrow = $repository->areSeancesToday( $day + 1 );
        if ( is_array( $data ) ) return $this->render( Setting::BUNDLE.':Default:table_full_schedule2.html.php', array( 'data' => $data, 'days' => $this->days2, 'areseancetomorrow' => $areSeanceTomorrow ) );
        return $this->render( Setting::BUNDLE.':Default:empty_schedule.html.php', array( 'maxRoom' => $data ) );
        
    }//end func
    
    
}//end class
