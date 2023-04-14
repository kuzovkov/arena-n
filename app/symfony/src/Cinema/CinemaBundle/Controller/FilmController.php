<?php

namespace Cinema\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Cinema\CinemaBundle\CinemaCinemaBundle;
use Cinema\CinemaBundle\Helper\Setting;
use Cinema\CinemaBundle\Helper\CacheControl;

class FilmController extends Controller
{
    protected $month = array( 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря' );
    protected $sharedEntities = array();
    /**
     * Controller for /film/{slug} router
     * @param string $slug Slug of films
     **/
    public function filmAction( $slug = '' )
    {
        $entities = array('Film', 'News', 'Schedule','Banner', 'Snipet');
        $result = CacheControl::cacheCheck($this->getDoctrine(),$this->getRequest(),new Response(), $entities, $this->sharedEntities);
        if (is_object($result)) return $result;
        
        $data = array();
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $repoSched = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Schedule");
        $repoBanners = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Banner");
        $data['film'] = $repository->getFilmInfo($slug);
        $id = $data['film']->getId();
        $data['datesstring'] = $repoSched->getDatesStringArray($id);
        $data['today'] = $repository->getFilmsTodayInfo();
        $repoNews = $this->getDoctrine()->getRepository("CinemaCinemaBundle:News");
        $data['news'] = $repoNews->getNews('CINEMA_NEWS');
        $data['month'] = $this->month;
        $data['format'] = $repoSched->filmHasFormats($id); 
        $data['filmbackground'] = $repository->getFilmOnBackground();
        $data['filmnameimage'] = $repository->getFilmImageName();
        $data['banners'] = $repoBanners->getBanners();
        $data['snipets'] = $this->getDoctrine()->getRepository(Setting::BUNDLE.":Snipet")->getAllSnipets();
        if ( !$data['film'] ) 
            return $this->redirect($this->generateUrl('cinema_cinema_index'));
        $response =  $this->render('CinemaCinemaBundle:Default:film.html.twig', array( 'data'=> $data, 'month' => $this->month )); 
        return CacheControl::setCacheHeaders($this->getRequest(), $response,$result['lastmodified'],$result['etag']);
    }//end func
        
}