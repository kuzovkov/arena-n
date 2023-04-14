<?php

namespace Cinema\CinemaBundle\Controller;
 
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Cinema\CinemaBundle\Entity\News;
 
class NewsAdminController extends Controller
{
    public function createAction($id=null)
    {
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $request = $this->get('request');
        $uniqid = $request->query->get('uniqid');
        if ( isset( $uniqid ) )
        {
             $post = $request->request->get( $uniqid );
             $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:News");
             $news = $repository->getNewsFromForm($id,$post);
             $em = $this->getDoctrine()->getManager();
             $em->persist( $news );
             $em->flush();
             $id = $news->getId();
             $ext = $repository->uploadImg($uniqid, $id);
             if ($ext) $news->setImg($id.$ext);
             $em->flush();
             
             if ( $request->get('btn_create_and_edit') )
             {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_news_edit', array( 'id' => $id ) ) );
             }
             else if ( $request->get('btn_create_and_list') )
             {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_news_edit' ) );
             }
             else
             {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_news_create' ) );
             }
        }
        else
        {
            $response = parent::createAction();
            return $response;
        }
    }
    
    public function editAction($id=null)
    {
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $request = $this->get('request');
        $uniqid = $request->query->get('uniqid');
        if ( isset( $uniqid ) )
        {
             $post = $request->request->get( $uniqid );
             $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:News");
             $news = $repository->getUpdatedNewsFromForm($id,$post);
             $ext = $repository->uploadImg($uniqid, $id);
             if ($ext) $news->setImg($id.$ext);
             $em = $this->getDoctrine()->getManager();
             $em->persist( $news );
             $em->flush();
             if ( $request->get('btn_update_and_list') )
             {
                 return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_news_list' ) ); 
             }
             else
             {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_news_edit', array( 'id' => $id ) ) );
             }
        }
       
        $response = parent::editAction();
        return $response;
       
    }//end func
    
    public function deleteAction($id=null)
    {
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:News");
        $repository->delNewsImg($id);
        $response = parent::deleteAction($id);
        return $response;
       
    }//end func
    
    public function showAction($id=null)
    {
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $response = parent::showAction($id);
        return $response;
       
    }//end func
    
    public function listAction()
    {
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $response = parent::listAction();
        return $response;
       
    }//end func
    
}//end class