<?php

namespace Cinema\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Cinema\CinemaBundle\CinemaCinemaBundle;

class UploadController extends Controller
{
    public function getImageListAction()
    {
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Page");
        $files = $repository->getListImage();
        return $this->render('CinemaCinemaBundle:Admin:image_list.json.php', array('files' => $files)); 
    }//end func
    
    public function getImageFormUploadAction($id=null,$form)
    {
        return $this->render('CinemaCinemaBundle:Admin:form_image_upload.html.php', array('id'=>$id,'form'=>$form));
    }//end func
    
    public function imageUploadAction($id=null)
    {
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Page");
        if ( $repository->uploadImage() )
            return $this->render( 'CinemaCinemaBundle:Admin:file_upload_success.html.twig', array('id'=>$id ) );
        return $this->render( 'CinemaCinemaBundle:Admin:file_upload_fail.html.twig', array('id'=>$id ) );
    }//end func
    
    public function imageUploadWallAction($id=null)
    {
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        if ( $repository->uploadImageWall($id ) )
            return $this->render( 'CinemaCinemaBundle:Admin:image_upload_success.html.twig', array('id'=>$id ) );
        return $this->render( 'CinemaCinemaBundle:Admin:image_upload_fail.html.twig', array('id'=>$id ) );
    }//end func
    
    public function imageUploadNameAction($id=null)
    {
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        if ( $repository->uploadImageName($id ))
            return $this->render( 'CinemaCinemaBundle:Admin:image_upload_success.html.twig', array('id'=>$id ) );
        return $this->render( 'CinemaCinemaBundle:Admin:image_upload_fail.html.twig', array('id'=>$id ) );
    }//end func

    public function trailerLoadAction( $id=null )
    {
        $request = $this->get('request');
        $url = $request->request->get('trailer_url');
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        if ( $filename = $repository->loadTrailer( $url, $id ) )
           return $this->render( 'CinemaCinemaBundle:Admin:trailer_load_success.html.twig', array('id'=>$id, 'filename' => $filename ) );
        return $this->render( 'CinemaCinemaBundle:Admin:trailer_load_fail.html.twig', array('id'=>$id ) ); 
    }//end func
    
    public function deleteImageNameAction($id)
    {
        $repo = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
        $repo->deleteImageName($id);
        return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_film_edit', array( 'id' => $id ) ) );
    }

}