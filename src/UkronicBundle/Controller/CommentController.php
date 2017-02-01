<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UkronicBundle\Entity\LikeComment;
use UkronicBundle\Entity\Histo;

class CommentController extends Controller
{
    /**
     * @Route("/comment/islike/{id}/{userId}")
     */
    public function IsLikeAction($id, $userId)
    {
        $em = $this->getDoctrine()->getManager();
    	
        $likeCommentRepository = $em->getRepository("UkronicBundle:LikeComment");
        $liked = $likeCommentRepository->isLiked($id,$userId);
        $nbLiked = $likeCommentRepository->nbLiked($id);
       
        return $this->render('UkronicBundle:Comment:like.html.twig', array(
        	'liked' => $liked,
            'nbLiked' => $nbLiked,
        	'commentId' => $id,
        	'userId' => $userId
            // ...
        ));
    }

    /**
     * @Route("/comment/like/{id}/{userId}", name="commentLike")
     */
    public function LikeAction($id, $userId){
    	$em = $this->getDoctrine()->getManager();
    	$user = $em->getRepository('UkronicBundle:User')->findOneById($userId);
    	$comment = $em->getRepository('UkronicBundle:Comment')->findOneById($id);
    	$likeComment = new LikeComment();
    	$likeComment->setDateLikeComment(new \DateTime('now'));
    	$likeComment->setUser($user);
    	$likeComment->setComment($comment);
    	$em->persist($likeComment);
    	$em->flush();
    	// ajouter dans historique
    	$histo = new Histo();
    	$histo->setUser($user);
    	$histo->setAction(5);
    	$histo->setDateAction(new \DateTime('now'));
        $histo->setReference($id);
    	$em->persist($histo);
    	$em->flush();
    	return $this->redirectToRoute('decryptRead',array('id' =>$comment->getDecrypt()->getId()));
    }

    /**
     * @Route("/comment/like/display/{id}", name="commentLikeDisplay")
     */
    public function LikeDisplayAction($id){
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('UkronicBundle:Comment')->findOneById($id);
        if ($comment) {
        return $this->render('UkronicBundle:Comment:likeDisplay.html.twig',array('comment'=>$comment));
        } else {
            return null;
        }
    }



}
