<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UkronicBundle\Entity\User;

class AdminController extends Controller
{
    /**
     * @Route("/admin/users",name="adminUsers")
     */
    public function usersAction()    
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('UkronicBundle:User');
    	$users = $repository->findAll();
        return $this->render('UkronicBundle:Admin:users.html.twig', array(
        	'users'=> $users
            // ...
        ));
    }

}
