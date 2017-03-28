<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class UkronicController extends Controller
{
    /**
     * @Route("/Recherche/{title}", options={"expose"=true},name="ukronic-recherche")
     */
    public function rechercheAction($title="Highlander")
    {
    	
    	// utiliser les services pour récupérer la liste
    	$serviceMovie = $this->get('ukronic.infomovie');
            

        $movies = $serviceMovie->listeMovies($title);
        $series = $serviceMovie->listeSeries($title);

        return $this->render('UkronicBundle:Ukronic:recherche.html.twig', array(
        	'title' => $title,
        	'movies'=> $movies,
        	'series'=> $series
            // ...
        ));
    }

    /**
     * @Route("/MaRecherche", name="ukronic-recherche-bis")
     * @Method({"POST"})
     */
    public function rechercheBisAction(Request $request)
    {
        
        

        if (null !== $request->request->get('form')) {
        // utiliser les services pour récupérer la liste
            $data = $request->request->get('form');
            
            $title = $data['title'];
            
            $serviceMovie = $this->get('ukronic.infomovie');

            $movies = $serviceMovie->listeMoviesTMDB($title);
            $series = $serviceMovie->listeSeriesTMDB($title);
        

        return $this->render('UkronicBundle:Ukronic:rechercheTMDB.html.twig', array(
            'title' => $title,
            'movies'=> $movies,
            'series'=> $series
            // ...
        ));
        }
        return $this->redirectToRoute('main');
    }

     /**
     * @Route("/ukronic/cgu", name="ukronic-cgu")
     */
    public function cguUkronicAction(){
        return $this->render('UkronicBundle:User:cgu.html.twig');
    }

      /**
     * @Route("/ukronic/apropos", name="ukronic-apropos")
     */
    public function aproposUkronicAction(){
        return $this->render('UkronicBundle:User:apropos.html.twig');
    }

}
