<?php

namespace Cinema\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Cinema\CinemaBundle\Entity\Schedule;

class ScheduleController extends Controller
{
    protected $days = array( 'ВС','ПН','ВТ','СР','ЧТ','ПТ','СБ' );
    
     /**
     * Controller for AJAX query to add film seances to table schedule (in Admin panel)
     * 
     **/
     public function scheduleAction()
    {
        $request = $this->get('request');
        $dates = $request->request->get('dates');
        $hour = $request->request->get('hour');
        $min = $request->request->get('min');
        $price = intval( $request->request->get('price') );
        $room = intval( $request->request->get('room') );
        $id = intval( $request->request->get('id') );
        $is3d = $request->request->get('is3d');
        $arrayDate = explode( ',', $dates );
        
        $newSeances = array();
        foreach( $arrayDate as $date )
        {
            $seance = new Schedule();
            $seance->setFilmId( $id );
            $seance->setNumberRoot( $room );
            $seance->setPrice( $price );
            $seance->setIs3d(($is3d == 'true')?true:false);
            $seance->setTimeBegin( date_create( $date . ' ' . $hour . ':' . $min . ':' . '00' ) );
            $newSeances[] = $seance;
        }
        $messErr = true;
        if ( $this->checkSchedule( $id, $newSeances ) )
        {
            foreach( $newSeances as $seance )
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist( $seance );
                $em->flush();
                unset( $seance );
                unset( $em );
            }
            $messErr = false;
        }
        $repository = $this->getDoctrine()->getRepository('CinemaCinemaBundle:Schedule');
        $seances = $repository->findBy( array( 'film_id' => $id ), array( 'time_begin' => 'ASC' ));
        if ( !$seances ) return $this->render( "CinemaCinemaBundle:Schedule:empty_schedule.html.twig" );
        return $this->viewSchedule( $seances, $this->days, $messErr );
    }//end func
    
    
     /**
     * Controller for AJAX query to get table of schedule (in Admin panel)
     * 
     **/
    public function getScheduleTableAction()
    {
        $request = $this->get('request');
        $id = $request->request->get('id');
        if ( !isset( $id ) ) return $this->render( "CinemaCinemaBundle:Schedule:empty_schedule.html.twig" );
        $repository = $this->getDoctrine()->getRepository('CinemaCinemaBundle:Schedule');
        $data = array();
        $seances = $repository->findBy( array( 'film_id' => $id ), array( 'time_begin' => 'ASC' ));
        if ( !$seances ) return $this->render( "CinemaCinemaBundle:Schedule:empty_schedule.html.twig" );
        return $this->viewSchedule( $seances, $this->days );
        
    }//end func
    
    
    /**
     * Controller for AJAX query to delete record in table of schedule (in Admin panel)
     * 
     **/
    public function delScheduleRecordAction()
    {
        $request = $this->get('request');
        $id = $request->request->get('id');
        $filmId = $request->request->get('film_id');
        if ( !isset( $id ) || !isset( $filmId ) ) return $this->render( "CinemaCinemaBundle:Schedule:empty_schedule.html.twig" );
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CinemaCinemaBundle:Schedule');
        $seance = $repository->find($id);
        if ( $seance )
        {
            $em->remove($seance);
            $em->flush();
        }
        $seances = $repository->findBy( array( 'film_id' => $filmId ), array( 'time_begin' => 'ASC' ));
        if ( !$seances ) return $this->render( "CinemaCinemaBundle:Schedule:empty_schedule.html.twig" );
        return $this->viewSchedule( $seances, $this->days );
        
    }//end func
    
    
    /**
     * Controller for AJAX query to get edit form schedules (in Admin panel)
     * 
     **/
    public function getFormBlockAction()
    {
        return $this->render( "CinemaCinemaBundle:Schedule:form_schedule.html.twig" );
    }//end func
    
    public function checkScheduleAction()
    {
        $request = $this->get('request');
        $filmId = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CinemaCinemaBundle:Film');
        $film = $repository->find( $filmId );
        if ( !$film ) return $this->render( "CinemaCinemaBundle:Schedule:error_schedule.html.twig" );
        $duration = $film->getRawDuration();
        unset( $repository );
        $repository = $em->getRepository('CinemaCinemaBundle:Schedule');
        $seances = $repository->findBy( array( 'film_id' => $filmId ), array( 'time_begin' => 'ASC' ) );
        if ( !$seances ) return $this->render( "CinemaCinemaBundle:Schedule:noerror_schedule.html.twig" );
        $count = count( $seances );
        for ( $i = 0; $i < $count - 1; $i++ )
        {
            for ( $j = $i + 1; $j < $count; $j++ )
            {
                if ( $seances[$i]->getNumberRoot() != $seances[$j]->getNumberRoot() ) continue;
                $deltaTime = $seances[$j]->getTimeBegin()->getTimestamp() - $seances[$i]->getTimeBegin()->getTimestamp();
                if ( ( $deltaTime < $duration * 60 ) ) return $this->render( "CinemaCinemaBundle:Schedule:error_schedule.html.twig" );
            }
        }
        return $this->render( "CinemaCinemaBundle:Schedule:noerror_schedule.html.twig" );
    }//end func
    
    
    /**
     * Check possible errors by adding sessions to the schedule  (in Admin panel)
     * @param int $filmId Film id
     * @param array $newSeances Array of seances
     * @return boolean true if Ok false if Fail
     **/
    protected function checkSchedule( $filmId, $newSeances )
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CinemaCinemaBundle:Film');
        $film = $repository->find( $filmId );
        if ( !$film ) return false;
        $duration = $film->getRawDuration();
        unset( $repository );
        $repository = $em->getRepository('CinemaCinemaBundle:Schedule');
        $seances = $repository->findBy( array( 'film_id' => $filmId ), array( 'time_begin' => 'ASC' ) );
        if ( !$seances ) return true;
        foreach( $newSeances as $newSeance ) $seances[] = $newSeance;
        $count = count( $seances );
        for ( $i = 0; $i < $count - 1; $i++ )
        {
            for ( $j = $i + 1; $j < $count; $j++ )
            {
                if ( $seances[$i]->getNumberRoot() != $seances[$j]->getNumberRoot() ) continue;
                $deltaTime = $seances[$j]->getTimeBegin()->getTimestamp() - $seances[$i]->getTimeBegin()->getTimestamp();
                if ( ( abs( $deltaTime ) < $duration * 60 ) ) return false;
            }
        }
        return true;
    }//end func
    
    
    /**
     * Controller for AJAX query to delete all seances of film in schedule (in Admin panel)
     * 
     **/
    public function delAllSeancesAction()
    {
        $request = $this->get('request');
        $filmId = $request->request->get('id');
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Schedule");
        $repository->delScheduleByFilmId( $filmId );
        $seances = $repository->findBy( array( 'film_id' => $filmId ), array( 'time_begin' => 'ASC' ));
        if ( !$seances ) return $this->render( "CinemaCinemaBundle:Schedule:empty_schedule.html.twig" );
        return $this->viewSchedule( $seances, $this->days );
        
    }//end func
    
    
    /**
     * Get table seances of schedule film
     * 
     **/
    protected function viewSchedule( $seances, $days, $error = false )
    {
        return $this->render( "CinemaCinemaBundle:Schedule:table_schedule.html.php", array( 'seances' => $seances, 'days' => $days, 'error' => $error ) );
    }//end func
    
    
    /**
     * Controller for AJAX query to get Confirm dialog by add seances (in Admin panel)
     * 
     **/
    public function getConfirmDialogAction()
    {
        $request = $this->get('request');
        $data = array();
        $data['dates'] = $request->request->get('dates');
        $data['hour'] = $request->request->get('hour');
        $data['min'] = $request->request->get('min');
        $data['price'] = intval( $request->request->get('price') );
        $data['room'] = intval( $request->request->get('room') );
        $data['is3d'] = $request->request->get('is3d');
        return $this->render( 'CinemaCinemaBundle:Schedule:confirm_schedule.html.twig', array( 'data' => $data ) );
    }//end func
    
    
    /**
     * Controller for AJAX query to get Confirm dialog by delete all seances (in Admin panel)
     * 
     **/
    public function getConfirmDelAllDialogAction()
    {
        return $this->render( 'CinemaCinemaBundle:Schedule:confirm_del_all_seances.html.twig' );
    }
    
}//end class