<?php

namespace UkronicBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UkronicBundle\Entity\MovieQuery;
use UkronicBundle\Entity\Movie;
use UkronicBundle\Entity\Decrypt;
use UkronicBundle\Repository\DecryptRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
// use Symfony\Component\Validator\Constraints\Date;


class DefaultController extends Controller
{
    /**
     * @Route("/depart", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/testons", name="testons")
     */
    public function testonsAction()
    {
        // replace this example code with whatever you need
        return $this->render('::base.html.twig');
    }
   
   /**
     * @Route("/", name="main")
     */
    public function mainAction() {
        // page principale
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");
        $lastMovieDecrypts = $decryptRepository->movieLastDecrypted();
        $lastSerieDecrypts = $decryptRepository->serieLastDecrypted();

        return $this->render('UkronicBundle:ukronic:main.html.twig', array(
                "lastMovieDecrypts" => $lastMovieDecrypts,
                "lastSerieDecrypts" => $lastSerieDecrypts
            ));
    }

   /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        // page de recherche
        // mettre en place un formulaire
        // prévoir l'affichage des réponses
        $movieRequest = new MovieQuery();

        $form = $this->createFormBuilder($movieRequest)
           
            ->add('title',TextType::class)
            
            ->add('save', SubmitType::class, array('label' => 'Rechercher'))
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
            $movieRequest = $form->getData();
            $message = "formulaire validé";
            // faire l'appel de l'API allociné
            $serviceMovie = $this->get('ukronic.infomovie');
            $myTitle = $movieRequest->getTitle();

            $reponse = $serviceMovie->listeMovies($myTitle);
            $message = $reponse;
        

        
        } else {
            $message = "en cours de saisie";
        }

        
        return $this->render('UkronicBundle:ukronic:search.html.twig',array(
            'form'=>$form->createView(),
            'movieRequest'=> $movieRequest,
            'message'=>$message
            ));
    }

    /**
     * @Route("/search/serie", name="searchSerie")
     */
    public function searchSerieAction(Request $request)
    {
        // page de recherche
        // mettre en place un formulaire
        // prévoir l'affichage des réponses
        $movieRequest = new MovieQuery();

        $form = $this->createFormBuilder($movieRequest)
           
            ->add('title',TextType::class)
            
            ->add('save', SubmitType::class, array('label' => 'Rechercher'))
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
            $movieRequest = $form->getData();
            $message = "formulaire validé";
            // faire l'appel de l'API allociné
            $serviceMovie = $this->get('ukronic.infomovie');
            $myTitle = $movieRequest->getTitle();

            $reponse = $serviceMovie->listeSeries($myTitle);
            $message = $reponse;
        

        
        } else {
            $message = "en cours de saisie";
        }

        
        return $this->render('UkronicBundle:ukronic:searchSerie.html.twig',array(
            'form'=>$form->createView(),
            'movieRequest'=> $movieRequest,
            'message'=>$message
            ));
    }

    /**
     * @Route("/movie/{imdbID}/{typeMovie}", name="movie")
     */
    public function movieAction($imdbID,$typeMovie) {

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
        switch ($typeMovie) {
            case 'F':
                  $movie = $serviceMovie->detailMovie($imdbID);        
                break;
            case 'S':
                 $movie = $serviceMovie->detailSerie($imdbID);        
            default:
                          # code...
                break;
            }          

        
        
        

        $em->persist($movie);
        $em->flush();
        }

     
        if ($movie == null) {
            return $this->redirect(path("main"));
        }
        return $this->render("UkronicBundle:ukronic:movie.html.twig",array("movie"=>$movie));
    }

    /**
     * @Route("/dbukronic/{id}", name="dbukronic")
     */
    public function dbukronicAction($id){

        // $movie = new Movie();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Movie");
        // vérifier si le film existe dans la BDD Ukronic
        $result = $repository->findOneById($id);

        if ($result) {
            $movie = $result;
        } 

     
        if ($movie == null) {
            return $this->redirectToRoute("main");
        }
        return $this->render("UkronicBundle:ukronic:movie.html.twig",array("movie"=>$movie));
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profileAction(){

        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $nbComment = count($user->getDecrypts());
        $nbSequence = $decryptRepository->sequenceDecrypted($user);
        $nbSequence100 = $decryptRepository->sequenceM100Decrypted($user);
        $nbSequence300 = $decryptRepository->sequenceM300Decrypted($user);
        $nbSequenceO300 = $decryptRepository->sequenceO300Decrypted($user);
        $nbEnd = $decryptRepository->endDecrypted($user);
        $nbEnd100 = $decryptRepository->endM100Decrypted($user);
        $nbEnd300 = $decryptRepository->endM300Decrypted($user);
        $nbEndO300 = $decryptRepository->endO300Decrypted($user);


        return $this->render("UkronicBundle:ukronic:profile.html.twig",array(
            'nbComment' => $nbComment,
            'nbSequence' => $nbSequence,
            'nbSequence100' => $nbSequence100,
            'nbSequence300' => $nbSequence300,
            'nbSequenceO300' => $nbSequenceO300,
            'nbEnd' => $nbEnd,
            'nbEnd100' => $nbEnd100,
            'nbEnd300' => $nbEnd300,
            'nbEndO300' => $nbEndO300

            ));
    }

     /**
     * @Route("/decrypt/{idMovie}", name="decrypt")
     */
    public function decryptAction($idMovie, Request $request){

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        //if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER') === true) {
        if (!$user) {
            
            $this->redirectToRoute("dbukronic",array("id"=>$idMovie));
        }
        

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Movie");
        // vérifier si le film existe dans la BDD Ukronic
        $movie = $repository->findOneById($idMovie);

        $decrypt = new Decrypt();



        $form = $this->createFormBuilder($decrypt)
           
            ->add('title',TextType::class)
            ->add('content',TextareaType::class)
            ->add('typeDecrypt',ChoiceType::class,array("choices"=> array(
                    'hypothèse de fin' => "F",
                    'Séquence' => "S"
                )))
            
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
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
            return $this->redirectToRoute("dbukronic",array("id"=>$idMovie));
            
        } 

       
        return $this->render("UkronicBundle:ukronic:decrypt.html.twig", array("movie"=>$movie, "form"=>$form->createView()));
    }

     /**
     * @Route("/decrypt/read/{id}", name="decryptRead")
     */
    public function decryptReadAction($id){

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Decrypt");
        // vérifier existence dans la BDD Ukronic
        $decrypt = $repository->findOneById($id);

             return $this->render("UkronicBundle:ukronic:decryptDisplay.html.twig", array("decrypt"=>$decrypt));
    }

}
