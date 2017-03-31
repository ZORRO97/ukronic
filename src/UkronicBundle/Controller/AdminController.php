<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class AdminController extends Controller
{
    /**
     * @Route("/admin/users",name="usersAdmin")
     */
    public function usersAdminAction()    

    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('UkronicBundle:User');
    	$users = $repository->findAll();
        return $this->render('UkronicBundle:Admin:users.html.twig', array(
        	'users'=> $users
            // ...
        ));
    }



    /**
     * @Route("/admin/dashboard",name="dashboardAdmin")
     */
    public function dashboardAdminAction() {
        $em = $this->getDoctrine()->getManager();

        $usersRepository = $em->getRepository("UkronicBundle:User");
        $nbUsers = $usersRepository->countUsers();

        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $nbDecrypts = $decryptRepository->countDecrypts();

        $commentRepository = $em->getRepository("UkronicBundle:Comment");
        $nbComments = $commentRepository->countComments();

        $signalRepository = $em->getRepository("UkronicBundle:Signalement");
        $nbSignalements = $signalRepository->countSignalements();

        $movieRepository = $em->getRepository("UkronicBundle:Movie");
        $nbMovies = $movieRepository->countMovies();
        $nbSeries = $movieRepository->countSeries();

        $belovedRepository = $em->getRepository("UkronicBundle:Beloved");
        $nbLikes = $belovedRepository->countLikes();

        $likeCommentRepository = $em->getRepository("UkronicBundle:LikeComment");
        $nbLikeComments = $likeCommentRepository->countLikeComments();
        

        return $this->render('UkronicBundle:Admin:dashboard.html.twig',array(
            'nbUsers' => $nbUsers,
            'nbDecrypts' => $nbDecrypts,
            'nbComments' => $nbComments,
            'nbSignalements' => $nbSignalements,
            'nbMovies' => $nbMovies,
            'nbSeries' => $nbSeries,
            'nbLikes' => $nbLikes,
            'nbLikeComments' => $nbLikeComments
            ));
    }

    /**
     * @Route("/admin/signalement",name="signalementAdmin")
     */
    public function signalementAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Signalement');
        $signalements = $repository->allAlerts();
        
        return $this->render('UkronicBundle:Admin:signalement.html.twig',array('signalements'=>$signalements));
    } 

    /**
     * @Route("/admin/movies",name="moviesAdmin")
     */
    public function moviesAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Movie');
        $movies = $repository->allMovies();
        
        return $this->render('UkronicBundle:Admin:movies.html.twig',array('movies'=>$movies));
    } 

    /**
     * @Route("/admin/series",name="seriesAdmin")
     */
    public function seriesAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Movie');
        $series = $repository->allSeries();
       
        return $this->render('UkronicBundle:Admin:series.html.twig',array('series'=>$series));
    } 

    /**
     * @Route("/admin/decrypt",name="decryptAdmin")
     */
    public function decryptAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Decrypt');
        $decrypts = $repository->findAll();
        
        return $this->render('UkronicBundle:Admin:decrypt.html.twig',array('decrypts'=>$decrypts));
    } 

    /**
     * @Route("/admin/comment",name="commentAdmin")
     */
    public function commentAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Comment');
        $comments = $repository->findAll();
        
        return $this->render('UkronicBundle:Admin:comment.html.twig',array('comments'=>$comments));
    } 

    /**
     * @Route("/admin/likes",name="likesAdmin")
     */
    public function likesAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Beloved');
        $likes = $repository->findAll();
        
        return $this->render('UkronicBundle:Admin:likes.html.twig',array('likes'=>$likes));
    } 

    /**
     * @Route("/admin/commentLikes",name="commentLikesAdmin")
     */
    public function commentLikesAdminAction() {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:LikeComment');
        $likeComments = $repository->findAll();
        
        return $this->render('UkronicBundle:Admin:commentLikes.html.twig',array('likeComments'=>$likeComments));
    } 

     



}
