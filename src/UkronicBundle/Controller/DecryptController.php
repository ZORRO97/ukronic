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
    public function DecryptMovieAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $decrypts = $decryptRepository->movieDateDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMoviedecrypts.html.twig',array('decrypts'=>$decrypts));
    }

    /**
     * @Route("/decrypt/serie/all", name="decryptSerieDateAll")
     */
    public function DecryptSerieAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $decrypts = $decryptRepository->serieDateDecrypted();
        return $this->render('UkronicBundle:Decrypt:allSerieDatedecrypts.html.twig',array('decrypts'=>$decrypts));
    }

    
    /**
     * @Route("/decrypt/movie/more/all", name="decryptMovieMoreAll")
     */
    public function DecryptMovieMoreAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->movieMoreAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMovieMoredecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/movie/moreRead/all", name="decryptMovieMoreReadAll")
     */
    public function DecryptMovieMoreReadAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->movieMoreReadAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allMovieMoreReadDecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/serie/moreRead/all", name="decryptSerieMoreReadAll")
     */
    public function DecryptSerieMoreReadAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->serieMoreReadAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allSerieMoreReadDecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/serie/more/all", name="decryptSerieMoreAll")
     */
    public function DecryptSerieMoreAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->serieMoreAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allSerieMoredecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/movie/like/all", name="decryptMovieLikeAll")
     */
    public function DecryptMovieLikeAllAction(){
        $em = $this->getDoctrine()->getManager();
        $belovedRepository = $em->getRepository('UkronicBundle:Beloved');
        $results = $belovedRepository->allLikedDecrypt();
        return $this->render('UkronicBundle:Decrypt:allMovieLikeDecrypts.html.twig',array('results'=>$results));
    }

/**
     * @Route("/decrypt/movie/comment/all", name="decryptMovieCommentAll")
     */
    public function DecryptMovieCommentAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->allCommentMovieDecrypts();
        return $this->render('UkronicBundle:Decrypt:allMovieCommentDecrypts.html.twig',array('results'=>$results));
    }

     /**
     * @Route("/decrypt/serie/like/all", name="decryptSerieLikeAll")
     */
    public function DecryptSerieLikeAllAction(){
        $em = $this->getDoctrine()->getManager();
        $belovedRepository = $em->getRepository('UkronicBundle:Beloved');
        $results = $belovedRepository->moreLikedSerieDecrypt();
        return $this->render('UkronicBundle:Decrypt:allSerieLikeDecrypts.html.twig',array('results'=>$results));
    }

/**
     * @Route("/decrypt/serie/comment/all", name="decryptSerieCommentAll")
     */
    public function DecryptSerieCommentAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->allCommentSerieDecrypts();
        return $this->render('UkronicBundle:Decrypt:allSerieCommentDecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/signaler/{id}", name="decryptSignalement")
     */
    public function decryptSignalementAction($id, Request $request){
        $user = $this->container->get('security.token_storage')->getToken()->getUser(); 
        if ($request->isXmlHttpRequest() and $user) {
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
