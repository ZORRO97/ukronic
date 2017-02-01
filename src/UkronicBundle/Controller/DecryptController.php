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

    /**
     * @Route("/decrypt/movie/all", name="decryptMovieDateAll")
     */
    public function DecryptMovieAllAction($id){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $decrypts = $decryptRepository->movieDateDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMoviedecrypts.html.twig',array('decrypts'=>$decrypts));
    }

    /**
     * @Route("/decrypt/serie/all", name="decryptSerieDateAll")
     */
    public function DecryptSerieAllAction($id){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $decrypts = $decryptRepository->serieDateDecrypted();
        return $this->render('UkronicBundle:Decrypt:allSerieDatedecrypts.html.twig',array('decrypts'=>$decrypts));
    }

    
    /**
     * @Route("/decrypt/movie/more/all", name="decryptMovieMoreAll")
     */
    public function DecryptMovieMoreAllAction($id){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->movieMoreAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMovieMoredecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/movie/moreRead/all", name="decryptMovieMoreReadAll")
     */
    public function DecryptMovieMoreReadAllAction($id){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->movieMoreReadAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMovieMoreReadDecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/serie/more/all", name="decryptSerieMoreAll")
     */
    public function DecryptSerieMoreAllAction($id){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->serieMoreAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allSerieMoredecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/movie/like/all", name="decryptMovieLikeAll")
     */
    public function DecryptMovieLikeAllAction($id){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->movieLikeAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMovieLikeDecrypts.html.twig',array('results'=>$results));
    }

}
