<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use UkronicBundle\Entity\Signalement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DecryptController extends Controller
{
    
    /**
     * @Route("/displayDecrypt/{idMovie}/{filter}/{typeDecrypt}", name="displayDecrypt")
     */
    public function displayAction($idMovie, $filter=null,$typeDecrypt='S')
    {
    	$em = $this->getDoctrine()->getManager();
    	
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
        
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $decrypt = $decryptRepository->findOneById($id);


        return $this->render('UkronicBundle:Decrypt:decryptDetailDisplay.html.twig', array(
            "decrypt" => $decrypt
            
             
        ));
    }

    /**
     * @Route("/commentDecrypt/{id}", name="commentDisplayDecrypt")
     */
    public function commentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $decrypt = $decryptRepository->findOneById($id);


        return $this->render('UkronicBundle:Decrypt:decryptCommentDisplay.html.twig', array(
            "decrypt" => $decrypt
            
             
        ));
    }

    /**
     * @Route("/likeDecrypt/{id}", name="likeDisplayDecrypt")
     */
    public function likeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $decrypt = $decryptRepository->findOneById($id);


        return $this->render('UkronicBundle:Decrypt:decryptLikeDisplay.html.twig', array(
            "decrypt" => $decrypt
            
             
        ));
    }

    /**
     * @Route("/decrypt/movie/all", name="decryptMovieDateAll")
     */
    public function decryptMovieAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $decrypts = $decryptRepository->movieDateDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMoviedecrypts.html.twig',array('decrypts'=>$decrypts));
    }

    

    
    /**
     * @Route("/decrypt/movie/more/all", name="decryptMovieMoreAll")
     */
    public function decryptMovieMoreAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->movieMoreAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMovieMoredecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/movie/moreRead/all", name="decryptMovieMoreReadAll")
     */
    public function decryptMovieMoreReadAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->movieMoreReadAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMovieMoreReadDecrypts.html.twig',array('results'=>$results));
    }

    

    /**
     * @Route("/decrypt/movie/like/all", name="decryptMovieLikeAll")
     */
    public function decryptMovieLikeAllAction(){
        $em = $this->getDoctrine()->getManager();
        $belovedRepository = $em->getRepository('UkronicBundle:Beloved');
        $results = $belovedRepository->allLikedDecrypt();
        return $this->render('UkronicBundle:Decrypt:allMovieLikeDecrypts.html.twig',array('results'=>$results));
    }

/**
     * @Route("/decrypt/movie/comment/all", name="decryptMovieCommentAll")
     */
    public function decryptMovieCommentAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->allCommentMovieDecrypts();
        return $this->render('UkronicBundle:Decrypt:allMovieCommentDecrypts.html.twig',array('results'=>$results));
    }

     

    /**
     * @Route("/decrypt/signaler/{id}", name="decryptSignalement")
     */
    public function decryptSignalementAction($id, Request $request){
        $user = $this->container->get('security.token_storage')->getToken()->getUser(); 
        if ($request->isXmlHttpRequest() && $user) {
            // traiter la requête
            $signalement = new Signalement();

            $signalement->setDateSig(new \DateTime('now'));
            $signalement->setRef($id);
            $signalement->setType("D");
            $signalement->setStatus("A");
            $signalement->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($signalement);
            $em->flush();
            return new JsonResponse(array('reponse' => "Enfin une réponse de l'ajax"));
        }
        return new JsonResponse(array('reponse'=>'vous devez être identifié'));
    }
}
