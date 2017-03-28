<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminToolsController extends Controller
{

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
     * @Route("/admin/users/del/{id}",name="delUserAdmin")
     */
    public function delUserAdminAction($id,Request $request) {

        if ($request->isXmlHttpRequest()){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UkronicBundle:User');
        $user = $repository->findOneById($id);
        
        if ($user) {
            $em->remove($user);           
            $em->flush();
            return new JsonResponse(array('reponse' => "Enfin une réponse de l'ajax"));

        } else {
            return new JsonResponse(array('statut'=> false ,'reponse'=>'échec'));
        }
        }
        return false;
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
        if ($comment && $signal) {
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
        if ($decrypt && $signal) {
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
