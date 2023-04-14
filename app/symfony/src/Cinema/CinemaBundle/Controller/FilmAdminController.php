<?php

namespace Cinema\CinemaBundle\Controller;
 
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Cinema\ParseBundle\Controller\ParserController as Parser;
use Cinema\CinemaBundle\Entity\Film;
 
class FilmAdminController extends Controller
{
    
    public function createAction()
    {
        /*костыль для корректного ввода дат*/
        date_default_timezone_set('Europe/Minsk'); 
        
        $request = $this->get( 'request' );
        $id = $request->query->get( 'uniqid' );
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        if ( isset( $id ) )
        {
            $post = $request->request->get( $id );
            $url = $post['url'];
            if( $repository->checkUrl( $url ) )
            {
                $film = $repository->getFilmFromSite( $url );
            }
            else
            {
                $film = $repository->getFilmFromForm( $post );
            }  
            if ( $film !== false )
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist( $film );
                $em->flush();
                $id = $film->getId();
                $film = $repository->loadImages( $id, $film );
                $repository->loadTrailer( $film->getTrailerLink(),$id );
                $em->flush();
                if ( $request->get('btn_create_and_edit') )
                {
                    return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_film_edit', array( 'id' => $id ) ) );
                }
                else if ( $request->get('btn_create_and_list') )
                {
                    return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_film_list') );
                }
                else
                {
                    return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_film_create') );
                }
            }
            else
            {
                return $this->render( "CinemaCinemaBundle:Admin:film_error.html.twig" );
            }
        }
        else
        {
            $response = parent::createAction();
            return $response; 
        }
    }//end func
    
    
    public function editAction($id=null)
    {
        /*костыль для корректного ввода дат*/
        date_default_timezone_set('Europe/Minsk'); 
        
        $request = $this->get( 'request' );
        $uniqid = $request->query->get( 'uniqid' );
        if ( isset( $uniqid ) )
        {
            $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
			$repository->setNames();
            $em = $this->getDoctrine()->getManager();
            $film = $repository->find($id);
            $em->persist($film);
            $post = $request->request->get( $uniqid );
            $film->setPosterBig( $post['poster_big'] );
            $film->setPosterSmall( $post['poster_small'] );
            $film->setWallUrl( $post['wall_url'] );
            $film = $repository->loadImages( $id, $film );
            $em->flush();
            if (isset($post['onbackground']))
            {
                $repository->replaceBackground( $id );
            }
        }
		$repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $response = parent::editAction();
        return $response;
    }//end func
    
    public function deleteAction($id=null)
    {
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $repository->deletePostersAndSchedule( $id );
        $repository->deleteTrailer( $id );
        $response =  parent::deleteAction( $id );
        return $response;
    }//end func
    
    public function batchAction()
    {
        $response = parent::batchAction();
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Schedule");
        $repoFilm = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $repository->clearLostSeances();
        $repoFilm->deleteLostTrailres();
        $repoFilm->deleteLostPostersAndWall();
        return $response;
    }//end func
	
	public function listAction()
	{
		$repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
		$response =  parent::listAction();
        return $response;
	}//end func
	
	public function showAction($id=null)
	{
		$repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
		$response =  parent::showAction( $id );
        return $response;
	}//end func
    
    public function errorAction()
    {
        return $this->render( "CinemaCinemaBundle:Admin:film_error.html.twig" );
    }//end func
    
}//end class