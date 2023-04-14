<?php

namespace Cinema\CinemaBundle\Controller;
 
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Cinema\CinemaBundle\Entity\News;
 
class BannerAdminController extends Controller
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
             $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Banner");
             $banner = $repository->getBannerFromForm($id,$post);
             $em = $this->getDoctrine()->getManager();
             $em->persist( $banner );
             $em->flush();
             $id = $banner->getId();
             $ext = $repository->uploadImg($uniqid, $id);
             if ($ext) $banner->setImgfilename($id.$ext);
             $em->flush();
             if ( $request->get('btn_create_and_edit') )
             {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_banner_edit', array( 'id' => $id ) ) );
             }
             else if ( $request->get('btn_create_and_list') )
             {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_banner_list' ) );
             }
             else
             {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_banner_create' ) );
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
             $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Banner");
             $banner = $repository->getUpdatedBannerFromForm($id,$post);
             $ext = $repository->uploadImg($uniqid, $id);
             if ($ext) $banner->setImgfilename($id.$ext);
             $em = $this->getDoctrine()->getManager();
             $em->persist( $banner );
             $em->flush();
             if ( $request->get('btn_update_and_list') )
             {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_banner_list' ) );
             }
             else
             {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_banner_edit', array( 'id' => $id ) ) );
             }
             
        }
        $response = parent::editAction();
        return $response;
       
    }//end func
    
    public function deleteAction($id=null)
    {
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Banner");
        $repository->delBannerImg($id);
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
    
    public function batchAction($id=null)
    {
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $response = parent::batchAction($id);
        $repoBanner =  $this->getDoctrine()->getRepository("CinemaCinemaBundle:Banner");
        $repoBanner->deleteLostBanner();
        return $response;
       
    }//end func
    
    public function listAction()
    {
        
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $response = parent::listAction();
        return $response;
       
    }//end func
}