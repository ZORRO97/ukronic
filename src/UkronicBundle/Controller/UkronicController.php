<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UkronicController extends Controller
{
    /**
     * @Route("/Recherche/{title}", options={"expose"=true},name="ukronic-recherche")
     */
    public function RechercheAction($title="Highlander")
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

}
