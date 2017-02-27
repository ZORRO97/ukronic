<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UkronicBundle\Entity\Movie;

class SerieController extends Controller
{
    /**
     * @Route("/choiceSerie/{id}",name="choiceSerie")
     */
    public function choiceSerieAction($id)
    {
    	// utiliser le service pour récupérer dans un tableau les épisodes de toutes les saisons
    	$serviceMovie = $this->get('ukronic.infomovie');
    	$infos = $serviceMovie->detailSaisonSerie($id,1);
    	$results = array();
    	array_push($results, $infos);
    	$totalSaisons = $infos["totalSeasons"];
    	if ($totalSaisons > 1) {
    		$cpt=1;
    		while ($cpt < $totalSaisons) {
    			$cpt += 1;
    			$infos = $serviceMovie->detailSaisonSerie($id,$cpt);
    			array_push($results,$infos);
    		}
    	}
        return $this->render('UkronicBundle:Serie:choice_serie.html.twig', array(
            // ... les passer en paramètres
            'infos'=>$results
        ));
    }

    /**
     * @Route("/serie/{imdbID}/{titleSerie}", name="serie")
     */
    public function serieAction($imdbID,$titleSerie) {

        $movie = new Movie();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Movie");
        // vérifier si le film existe dans la BDD Ukronic
        $result = $repository->findOneByNumber($imdbID);

        if ($result) {
            $movie = $result;
        } else {


        // récupérer les infos en fonction de imdbID

        $serviceMovie = $this->get('ukronic.infomovie');  
        
        $movie = $serviceMovie->detailSerie($imdbID,$titleSerie);        
                  

        $em->persist($movie);
        $em->flush();
        }

        if ($movie == null) {
            return $this->redirect(path("main"));
        }
        return $this->render("UkronicBundle:Ukronic:movie.html.twig",array(
            "movie"=>$movie,
            "filter_end" => "-100",
            "filter_seq" => "-100"
            ));
    }

}
