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
    public function DetailAction($id,$typeDecrypt='S')
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $decrypt = $decryptRepository->findOneById($id);


        return $this->render('UkronicBundle:Decrypt:decryptDetailDisplay.html.twig', array(
            "decrypt" => $decrypt
            
             
        ));
    }

    /**
     * @Route("/commentDecrypt/{id}", name="commentDisplayDecrypt")
     */
    public function CommentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $decrypt = $decryptRepository->findOneById($id);


        return $this->render('UkronicBundle:Decrypt:decryptCommentDisplay.html.twig', array(
            "decrypt" => $decrypt
            
             
        ));
    }

    /**
     * @Route("/likeDecrypt/{id}", name="likeDisplayDecrypt")
     */
    public function LikeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $decrypt = $decryptRepository->findOneById($id);


        return $this->render('UkronicBundle:Decrypt:decryptLikeDisplay.html.twig', array(
            "decrypt" => $decrypt
            
             
        ));
    }



}
