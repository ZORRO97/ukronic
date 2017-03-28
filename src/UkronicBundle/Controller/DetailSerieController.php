<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DetailSerieController extends Controller
{

	/**
     * @Route("/decrypt/serie/all", name="decryptSerieDateAll")
     */
    public function decryptSerieAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $decrypts = $decryptRepository->serieDateDecrypted();
        return $this->render('UkronicBundle:Decrypt:allSerieDatedecrypts.html.twig',array('decrypts'=>$decrypts));
    }

    /**
     * @Route("/decrypt/serie/moreRead/all", name="decryptSerieMoreReadAll")
     */
    public function decryptSerieMoreReadAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->serieMoreReadAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allSerieMoreReadDecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/serie/more/all", name="decryptSerieMoreAll")
     */
    public function decryptSerieMoreAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->serieMoreAllDecrypted();
        return $this->render('UkronicBundle:Decrypt:allSerieMoredecrypts.html.twig',array('results'=>$results));
    }

    /**
     * @Route("/decrypt/serie/like/all", name="decryptSerieLikeAll")
     */
    public function decryptSerieLikeAllAction(){
        $em = $this->getDoctrine()->getManager();
        $belovedRepository = $em->getRepository('UkronicBundle:Beloved');
        $results = $belovedRepository->moreLikedSerieDecrypt();
        return $this->render('UkronicBundle:Decrypt:allSerieLikeDecrypts.html.twig',array('results'=>$results));
    }

	/**
     * @Route("/decrypt/serie/comment/all", name="decryptSerieCommentAll")
     */
    public function decryptSerieCommentAllAction(){
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $results = $decryptRepository->allCommentSerieDecrypts();
        return $this->render('UkronicBundle:Decrypt:allSerieCommentDecrypts.html.twig',array('results'=>$results));
    }
}
