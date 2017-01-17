<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UkronicBundle\Entity\LikeComment;

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
       
        return $this->render('UkronicBundle:Comment:like.html.twig', array(
        	'liked' => $liked,
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
    	return $this->redirectToRoute('decryptRead',array('id' =>$comment->getDecrypt()->getId()));
    }


}