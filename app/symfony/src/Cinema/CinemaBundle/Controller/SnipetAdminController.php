<?php

namespace Cinema\CinemaBundle\Controller;
 
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Cinema\CinemaBundle\Entity\Snipet;
 
class SnipetAdminController extends Controller
{
    public function createAction($id=null)
    {
        $response = parent::createAction();
        return $response;
    }
    
    public function editAction($id=null)
    {
        
        $response = parent::editAction();
        return $response;
       
    }//end func
    
    public function deleteAction($id=null)
    {
       
        $response = parent::deleteAction($id);
        return $response;
       
    }//end func
    
    public function showAction($id=null)
    {
        
        $response = parent::showAction($id);
        return $response;
       
    }//end func
    
    public function batchAction($id=null)
    {
        
        $response = parent::batchAction($id);
        return $response;
       
    }//end func
    
    public function listAction()
    {
        $response = parent::listAction();
        return $response;
       
    }//end func
}