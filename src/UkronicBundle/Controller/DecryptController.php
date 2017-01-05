<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UkronicBundle\Entity\Decrypt;

class DecryptController extends Controller
{
    
    /**
     * @Route("/displayDecrypt/{idMovie}/{filter}/{typeDecrypt}", name="displayDecrypt")
     */
    public function displayAction($idMovie, $filter=null,$typeDecrypt='S')
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->container->get('security.token_storage')->getToken()->getUser();
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $decrypts = $decryptRepository->getDecrypts($idMovie, $filter,$typeDecrypt);


        return $this->render('UkronicBundle:Decrypt:decryptSelectedDisplay.html.twig', array(
            "decrypts" => $decrypts,
            "filter" => $filter,
            "idMovie" => $idMovie 
        ));
    }

    /**
     * @Route("/detailDecrypt/{id}/{typeDecrypt}", name="detailDecrypt")
     */
    public function detailAction($id,$typeDecrypt='S')
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $decrypt = $decryptRepository->findOneById($id);


        return $this->render('UkronicBundle:Decrypt:decryptDetailDisplay.html.twig', array(
            "decrypt" => $decrypt
            
             
        ));
    }

}
