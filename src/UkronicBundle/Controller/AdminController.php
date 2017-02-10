<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use UkronicBundle\Entity\User;
use UkronicBundle\Entity\Movie;
use UkronicBundle\Entity\Decrypt;
use UkronicBundle\Entity\Comment;
use UkronicBundle\Entity\Beloved;
use UkronicBundle\Entity\LikeComment;
use UkronicBundle\Entity\Signalement;


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

    /**
     * @Route("/admin/comment/rendu/{id}/{idSig}",name="renduCommentAdmin")
     */
    public function renduCommentAdminAction($id,$idSig) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Comment');
        $comment = $repository->findOneById($id);
        
        return $this->render('UkronicBundle:Admin:renduComment.html.twig',array('comment'=>$comment,'idSig'=>$idSig));
        
    } 

    /**
     * @Route("/admin/decrypt/rendu/{id}/{idSig}",name="renduCommentAdmin")
     */
    public function renduDecryptAdminAction($id,$idSig) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Decrypt');
        $decrypt = $repository->findOneById($id);
        
        return $this->render('UkronicBundle:Admin:renduDecrypt.html.twig',array('decrypt'=>$decrypt,'idSig'=>$idSig));
        
    } 

     /**
     * @Route("/admin/comment/del/{id}/{idSig}",name="delCommentAdmin")
     */
    public function delCommentAdminAction($id,$idSig,Request $request) {

        if ($request->isXmlHttpRequest()){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Comment');
        $comment = $repository->findOneById($id);
        $signalRepository = $em->getRepository('UkronicBundle:Signalement');
        $signal = $signalRepository->findOneById($idSig);
        if ($comment AND $signal) {
            $em->remove($comment);
            $signal->setStatus("T");

            // du même coup changer le status du signalement
            $em->flush();
            return new JsonResponse(array('reponse' => "Enfin une réponse de l'ajax"));

        } else {
            return new JsonResponse(array('statut'=> false ,'reponse'=>'échec'));
        }
        }
        return false;
    } 

     /**
     * @Route("/admin/signalement/ignore/{idSig}",name="ignoreSignalementAdmin")
     */
    public function ignoreSignalementAdminAction($idSig,Request $request) {

        if ($request->isXmlHttpRequest()){
        $em = $this->getDoctrine()->getManager();
        
        $signalRepository = $em->getRepository('UkronicBundle:Signalement');
        $signal = $signalRepository->findOneById($idSig);
        if ($signal) {
            
            $signal->setStatus("I");

            // du même coup changer le status du signalement
            $em->flush();
            return new JsonResponse(array('reponse' => "Enfin une réponse de l'ajax"));

        } else {
            return new JsonResponse(array('statut'=> false ,'reponse'=>'échec'));
        }
        }
        return false;
    } 

     /**
     * @Route("/admin/decrypt/del/{id}/{idSig}",name="delDecryptAdmin")
     */
    public function delDecryptAdminAction($id,$idSig,Request $request) {

        if ($request->isXmlHttpRequest()){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:Decrypt');
        $decrypt = $repository->findOneById($id);
        $signalRepository = $em->getRepository('UkronicBundle:Signalement');
        $signal = $signalRepository->findOneById($idSig);
        if ($decrypt AND $signal) {
            $em->remove($decrypt);
            $signal->setStatus("T");

            // du même coup changer le status du signalement
            $em->flush();
            return new JsonResponse(array('reponse' => "Enfin une réponse de l'ajax"));

        } else {
            return new JsonResponse(array('statut'=> false ,'reponse'=>'échec'));
        }
        }
        return false;
    } 


}
