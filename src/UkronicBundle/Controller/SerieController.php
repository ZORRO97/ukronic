<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UkronicBundle\Entity\Movie;
use UkronicBundle\Entity\Decrypt;
use UkronicBundle\Entity\Histo;
use UkronicBundle\Entity\Rating;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
        if (array_key_exists('totalSeasons', $infos)){
        	$totalSaisons = $infos["totalSeasons"];
        	if ($totalSaisons > 1) {
        		$cpt=1;
        		while ($cpt < $totalSaisons) {
        			$cpt += 1;
        			$infos = $serviceMovie->detailSaisonSerie($id,$cpt);
        			array_push($results,$infos);
        		}
        	}
        }
        return $this->render('UkronicBundle:Serie:choice_serie.html.twig', array(
            // ... les passer en paramètres
            'infos'=>$results
        ));
    }

    /**
     * @Route("/choiceSerieTMDB/{id}",name="choiceSerieTMDB")
     */
    public function choiceSerieTMDBAction($id)
    {
        // utiliser le service pour récupérer dans un tableau les épisodes de toutes les saisons
        $serviceMovie = $this->get('ukronic.infomovie');
        $serieInfos = $serviceMovie->infoSerieTMDB($id);
        $infos = $serviceMovie->detailSaisonSerieTMDB($id,1);
        $results = array();
        array_push($results, $infos);
        if (array_key_exists('number_of_seasons', $serieInfos)){
            $totalSaisons = (int) $serieInfos["number_of_seasons"];
            if ($totalSaisons > 1) {
                $cpt=1;
                while ($cpt < $totalSaisons) {
                    $cpt += 1;
                    $infos = $serviceMovie->detailSaisonSerieTMDB($id,$cpt);
                    array_push($results,$infos);
                }
            }
        } else {
            $totalSaisons = 1;
        }
        return $this->render('UkronicBundle:Serie:choice_serie_tmdb.html.twig', array(
            // ... les passer en paramètres
            'infos'=>$results,
            'totalSaisons'=>$totalSaisons,
            'serieInfos'=>$serieInfos,
            'idSerie'=>$id
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
        return $this->render("UkronicBundle:Serie:episode.html.twig",array(
            "movie"=>$movie,            
            "filter_seq" => "all"
            ));
    }

    /**
     * @Route("/serieTMDB/{id}/{saison}/{episode}/{name}", name="serieTMDB")
     */
    public function serieTMDBAction($id,$saison,$episode,$name) {

        $movie = new Movie();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Movie");
        // vérifier si le film existe dans la BDD Ukronic
        $result = $repository->findEpisodeSerie($id,$saison,$episode);

        if ($result) {
            $movie = $result[0];
        } else {


        // récupérer les infos en fonction de tmdbID

            $serviceMovie = $this->get('ukronic.infomovie');  
            
            $movie = $serviceMovie->detailSerieTMDB($id,$saison,$episode,$name);        
                      
            if ($movie !== null){
                
                $em->persist($movie);
                $em->flush();
            }
        }

        if ($movie == null) {
            return $this->redirect(path("main"));
        }
        return $this->render("UkronicBundle:Serie:episode.html.twig",array(
            "movie"=>$movie,            
            "filter_seq" => "all"
            ));
    }

      /**
     * @Route("/episode/dbukronic/{id}/{filter_seq}", name="dbukronic-serie")
     */
    public function dbukronicSerieAction($id,$filter_seq="all"){

        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Movie");
        // vérifier si le film existe dans la BDD Ukronic
        $result = $repository->findOneById($id);
        // die(var_dump($result));

        if ($result) {
            $movie = $result;
        } else {
           // return $this->redirectToRoute("main");
        	die(var_dump($result));
        }

        return $this->render("UkronicBundle:Serie:episode.html.twig",array(
            "movie"=>$movie,
            "filter_seq" => $filter_seq
            ));
    }

     /**
     * @Route("/decrypt/episode/{idMovie}", name="decrypt-episode")
     */
    public function decryptEpisodeAction($idMovie, Request $request){

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        //if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER') === true) {
        if (!$user) {
            
            $this->redirectToRoute("dbukronic-serie",array("id"=>$idMovie));
        }
        

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Movie");
        // vérifier si le film existe dans la BDD Ukronic
        $movie = $repository->findOneById($idMovie);

        $decrypt = new Decrypt();
        $decrypt->setTypeDecrypt("S");
        
        $repositoryRating = $em->getRepository("UkronicBundle:Rating");
        $rating = $repositoryRating->trouve($user->getId(),$movie->getId());
        if (!$rating) {
            $rating = new Rating();
        } 




        $form = $this->createFormBuilder($decrypt)
           
            ->add('title',TextType::class)
            ->add('content',TextareaType::class)            
            ->add('prefered',HiddenType::class, array(
                    'mapped' => false,
                    
                    'attr'=> array('class' => "prefered",
                                    'value' => $rating->getNote()
                        )
                ))
            ->add('nocomprendo',HiddenType::class, array(
                    'mapped' => false,
                    
                    'attr'=> array('class' => "nocomprendo",
                            'value' => $rating->getAmbiguous()
                        )
                ))
            ->add('baleze',HiddenType::class, array(
                    'mapped' => false,
                    
                    'attr'=> array('class' => "baleze",
                        "value" => $rating->getUnderstand())
                ))
            
            ->add('save', SubmitType::class, array('label' => 'Publier'))
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        
            $decrypt = $form->getData();
            $decrypt->setDateDecrypt(new \DateTime('now'));
            $decrypt->setNbRead(0);
            $decrypt->setNbLiked(0);
            $decrypt->setWordCount(str_word_count($decrypt->getContent()));
            $decrypt->setMovie($movie);
            $decrypt->setUser($user);
            // raccorder au User connecté
            // enregistrer le décryptage
            $em->persist($decrypt);
            $em->flush();

            $prefered = $form['prefered']->getData();
            
            $nocomprendo = $form['nocomprendo']->getData();
            
            $baleze = $form['baleze']->getData();

            // $rating = new Rating();
            $rating->setMovie($movie);
            $rating->setUser($user);
            $rating->setNote($prefered);
            $rating->setAmbiguous($nocomprendo);
            $rating->setUnderstand($baleze);
            $em->persist($rating);

            $histo = new Histo();
            $histo->setUser($user);
            // ajouter les détails
            
            $histo->setAction(4);
            
            $histo->setDateAction(new \DateTime('now'));
            $histo->setReference($decrypt->getId());
            $em->persist($histo);


            $em->flush();
            return $this->redirectToRoute("dbukronic-serie",array("id"=>$idMovie));
            
        } 

       
        return $this->render("UkronicBundle:Serie:decrypt.html.twig", array("movie"=>$movie, "form"=>$form->createView()));
    }

}
