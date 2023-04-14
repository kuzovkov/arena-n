<?php

namespace Cinema\CinemaBundle\Controller;
 
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Cinema\CinemaBundle\Entity\User;


class UserAdminController extends Controller
{
    // Your code will be here
    
    public function createAction()
    {
        $request = $this->get( 'request' );
        $id = $request->query->get( 'uniqid' );
        if ( isset( $id ) ) 
        {
            $post = $request->request->get($id);
            $user = new User();
            $user->setEmail( $post['email'] );
            $user->setUsername( $post['username'] );
            $user->setRoles( $post['roles'] );
            $password = $post['password'];
            $salt = $user->getSalt();
            $password = $this->encodePassword( $password, $salt );
            $user->setPassword( $password );
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();
            
            return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_user_list' ) );
        }
        else
        {
            $response = parent::createAction();
            return $response; 
        }
       
    }//end func
    
    public function editAction($id=null)
    {
        $request = $this->get( 'request' );
        $uniqid = $request->query->get( 'uniqid' );
        if ( isset( $uniqid ) ) 
        {
            $post = $request->request->get($uniqid);
            $repository = $this->getDoctrine()->getRepository("CinemaCinemaBundle:User");
            $user = $repository->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $user->setEmail( $post['email'] );
            $user->setUsername( $post['username'] );
            $user->setRoles( $post['roles'] );
            $password = $post['password'];
            $salt = $user->getSalt();
            $password = $this->encodePassword( $password, $salt );
            $user->setPassword( $password );
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();
            if ( $request->get('btn_update_and_edit') )
            {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_user_edit', array( 'id' => $id ) ) );
            }
            else if ( $request->get('btn_update_and_list') )
            {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_user_list') );
            }
            else
            {
                return $this->redirect( $this->generateUrl( 'admin_cinema_cinema_user_create') );
            }
        }
        else
        {
            $response = parent::editAction();
            return $response; 
        }
    }//end func
    
    private function encodePassword(  $password, $salt, $algorithm = 'sha512', $iterations = 5000 )
    {
        
        $salted = $this->mergePasswordAndSalt( $password, $salt );
        $digest = hash( $algorithm, $salted, true );

        // "stretch" hash
        for ($i = 1; $i < $iterations; $i++) {
            $digest = hash( $algorithm, $digest.$salted, true );
        }

        return base64_encode($digest);
    }//end func

    private function mergePasswordAndSalt($password, $salt)
    {
        if (empty($salt)) {
            return $password;
        }

        return $password.'{'.$salt.'}';
    }//end func

     
}//end class