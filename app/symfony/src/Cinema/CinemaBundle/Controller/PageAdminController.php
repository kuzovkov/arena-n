<?php

namespace Cinema\CinemaBundle\Controller;
 
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Cinema\CinemaBundle\Entity\Page;
 
class PageAdminController extends Controller
{
    // Your code will be here
    public function editAction($id=null)
    {
        $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $request = $this->get('request');
        $uniqid = $request->query->get('uniqid');
        if ( isset( $uniqid ) )
        {
            if (get_magic_quotes_gpc())
            {
                $_POST[$uniqid]['content'] = stripslashes( $_POST[$uniqid]['content'] );
            }
        }
        $response = parent::editAction();
        return $response;
    }
	
	public function createAction()
	{
		$repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $response = parent::createAction();
        return $response;
	}
	
	public function listAction()
	{
		$repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $response = parent::listAction();
        return $response;
	}
	
	public function showAction($id=null)
	{
		$repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $response = parent::showAction($id);
        return $response;
	}
	
	public function deleteAction($id=null)
	{
		$repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:Film");
		$repository->setNames();
        $response = parent::deleteAction($id);
        return $response;
	}
    
}//end class