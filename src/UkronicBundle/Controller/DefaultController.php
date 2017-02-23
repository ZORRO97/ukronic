<?php

namespace UkronicBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UkronicBundle\Entity\MovieQuery;
use UkronicBundle\Entity\Movie;
use UkronicBundle\Entity\Decrypt;
use UkronicBundle\Entity\Rating;
use UkronicBundle\Entity\Histo;
use UkronicBundle\Entity\Beloved;
use UkronicBundle\Entity\Comment;
use UkronicBundle\Repository\DecryptRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



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
        $moreMovieDecrypts = $decryptRepository->movieMoreDecrypted();
        $moreSerieDecrypts = $decryptRepository->serieMoreDecrypted();

        return $this->render('UkronicBundle:Ukronic:main.html.twig', array(
                "lastMovieDecrypts" => $lastMovieDecrypts,
                "lastSerieDecrypts" => $lastSerieDecrypts,
                "moreMovieDecrypts" => $moreMovieDecrypts,
                "moreSerieDecrypts" => $moreSerieDecrypts
            ));
    }

   /**
     * @Route("/search/movie", name="movieSearch")
     */
    public function movieSearchAction()
    {
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");        
        $lastMovieDecrypts = $decryptRepository->movieLastDecrypted();        
        $moreMovieDecrypts = $decryptRepository->movieMoreDecrypted(); 
        $moreReadMovieDecrypts = $decryptRepository->moreReadMovieDecrypts();

        $belovedRepository = $em->getRepository("UkronicBundle:Beloved");
        $moreLikeDecrypts = $belovedRepository->moreLikedDecrypt(); 
        $moreCommentMovieDecrypts = $decryptRepository->moreCommentMovieDecrypts();     
        

        
        return $this->render('UkronicBundle:Ukronic:mainMovie.html.twig',array(
            
            'lastMovieDecrypts'=>$lastMovieDecrypts,
            'moreMovieDecrypts'=>$moreMovieDecrypts,
            'moreReadMovieDecrypts'=>$moreReadMovieDecrypts,
            'moreLikeDecrypts'=>$moreLikeDecrypts,
            'moreCommentMovieDecrypts'=>$moreCommentMovieDecrypts
            ));
    }

    /**
     * @Route("/search/serie", name="searchSerie")
     */
    public function searchSerieAction()
    {
        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository("UkronicBundle:Decrypt");        
        $lastSerieDecrypts = $decryptRepository->serieLastDecrypted();        
        $moreSerieDecrypts = $decryptRepository->serieMoreDecrypted(); 
        $moreReadSerieDecrypts = $decryptRepository->moreReadSerieDecrypts();

        $belovedRepository = $em->getRepository("UkronicBundle:Beloved");
        $moreLikeSerieDecrypts = $belovedRepository->moreLikedSerieDecrypt(); 
        $moreCommentSerieDecrypts = $decryptRepository->moreCommentSerieDecrypts();     
        

        
        return $this->render('UkronicBundle:Ukronic:mainSerie.html.twig',array(
            
            'lastSerieDecrypts'=>$lastSerieDecrypts,
            'moreSerieDecrypts'=>$moreSerieDecrypts,
            'moreReadSerieDecrypts'=>$moreReadSerieDecrypts,
            'moreLikeSerieDecrypts'=>$moreLikeSerieDecrypts,
            'moreCommentSerieDecrypts'=>$moreCommentSerieDecrypts
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
        return $this->render("UkronicBundle:Ukronic:movie.html.twig",array(
            "movie"=>$movie,
            "filter_end" => "-100",
            "filter_seq" => "-100"
            ));
    }

    

     /**
     * @Route("/dbukronic/{id}/{filter_end}/{filter_seq}", name="dbukronic")
     */
    public function dbukronicAction($id,$filter_end="-100",$filter_seq="-100"){

        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Movie");
        // vérifier si le film existe dans la BDD Ukronic
        $result = $repository->findOneById($id);

        if ($result) {
            $movie = $result;
        } else {
            return $this->redirectToRoute("main");
        }

        return $this->render("UkronicBundle:Ukronic:movie.html.twig",array(
            "movie"=>$movie,
            "filter_end" => $filter_end,
            "filter_seq" => $filter_seq
            ));
    }

    /**
     * @Route("/profile/{id}", name="profile")
     */
    public function profileAction($id){

        $em = $this->getDoctrine()->getManager();
        $decryptRepository = $em->getRepository('UkronicBundle:Decrypt');
        $userRepository = $em->getRepository('UkronicBundle:User');
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();
        $user = $userRepository->findOneById($id);

        
        $nbComment = count($user->getComments());
        $nbSequence = $decryptRepository->sequenceDecrypted($user);
        $nbSequence100 = $decryptRepository->sequenceM100Decrypted($user);
        $nbSequence300 = $decryptRepository->sequenceM300Decrypted($user);
        $nbSequenceO300 = $decryptRepository->sequenceO300Decrypted($user);
        $nbEnd = $decryptRepository->endDecrypted($user);
        $nbEnd100 = $decryptRepository->endM100Decrypted($user);
        $nbEnd300 = $decryptRepository->endM300Decrypted($user);
        $nbEndO300 = $decryptRepository->endO300Decrypted($user);

        $ratingRepository = $em->getRepository('UkronicBundle:Rating');
        $bestMovie = $ratingRepository->preferedMovie($user);
        $ambiguousMovie = $ratingRepository->ambiguousMovie($user);
        $understandMovie = $ratingRepository->balaiseMovie($user);

        $histoRepository = $em->getRepository('UkronicBundle:Histo');
        $lastHistos = $histoRepository->lastNews($user);

        $likesRepository = $em->getRepository('UkronicBundle:Beloved');
        $nbLikes = $likesRepository->nbLiked($user);
        



        return $this->render("UkronicBundle:Ukronic:profile.html.twig",array(
            'nbLikes' => $nbLikes,
            'nbComment' => $nbComment,
            'nbSequence' => $nbSequence,
            'nbSequence100' => $nbSequence100,
            'nbSequence300' => $nbSequence300,
            'nbSequenceO300' => $nbSequenceO300,
            'nbEnd' => $nbEnd,
            'nbEnd100' => $nbEnd100,
            'nbEnd300' => $nbEnd300,
            'nbEndO300' => $nbEndO300,
            'preferedMovie' => $bestMovie,
            'ambiguousMovie' => $ambiguousMovie,
            'understandMovie' => $understandMovie,
            'lastHistos' => $lastHistos,
            'user' => $user

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
        
        $repositoryRating = $em->getRepository("UkronicBundle:Rating");
        $rating = $repositoryRating->trouve($user->getId(),$movie->getId());
        if (!$rating) {
            $rating = new Rating();
        } 




        $form = $this->createFormBuilder($decrypt)
           
            ->add('title',TextType::class)
            ->add('content',TextareaType::class)
            ->add('typeDecrypt',ChoiceType::class,array("choices"=> array(
                    'hypothèse de fin' => "F",
                    'Séquence' => "S"
                )))
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
            if ($decrypt->getTypeDecrypt() == "F") {
            $histo->setAction(3); // faire un test 3 pour fin 4 pour séquence
            } else {
                $histo->setAction(4);
            }
            $histo->setDateAction(new \DateTime('now'));
            $histo->setReference($decrypt->getId());
            $em->persist($histo);


            $em->flush();
            return $this->redirectToRoute("dbukronic",array("id"=>$idMovie));
            
        } 

       
        return $this->render("UkronicBundle:Ukronic:decrypt.html.twig", array("movie"=>$movie, "form"=>$form->createView()));
    }

     /**
     * @Route("/decrypt/read/{id}", name="decryptRead")
     */
    public function decryptReadAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Decrypt");
        // vérifier existence dans la BDD Ukronic
        $decrypt = $repository->findOneById($id);
       
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $repositoryBeloved = $em->getRepository("UkronicBundle:Beloved");

        if ($user != "anon." ) {
        $liked = $repositoryBeloved->isLiked($user,$decrypt);
    } else {
        $liked = false;
    }

        $nbLiked = $repositoryBeloved->nbLikedDecrypt($id);

        // récupérer la liste des commentaires attachés au décryptage
        // ajouter un formulaire pour la saisie des commentaires
        $comment = new Comment();
        $form = $this->createFormBuilder($comment)
            ->add('content',TextareaType::class)
                       
            ->add('save', SubmitType::class, array('label' => 'Publier'))
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        
            $comment = $form->getData();
            $comment->setUser($user);
            $comment->setDecrypt($decrypt);
            $comment->setDateComment(new \DateTime('now'));

            $em->persist($comment);

            $histo = new Histo();
            $histo->setUser($user);
            $histo->setAction(1);            
            $histo->setDateAction(new \DateTime('now'));
            $histo->setReference($decrypt->getId());
            $em->persist($histo);

            $em->flush();



        } else {
            $nbRead = $decrypt->getNbRead();
            $decrypt->setNbRead($nbRead + 1);
            $em->persist($decrypt); // sauvegarde le cpt de lectures du 
            $em->flush();
        }



        return $this->render("UkronicBundle:Ukronic:decryptDisplay.html.twig", array(
            "decrypt"=>$decrypt,
            "liked" => $liked,
            'nbLiked' => $nbLiked,
            "user" => $user,            
            "form" => $form->createView()
            ));
    }

     /**
     * @Route("/decrypt/like/{id}", name="decryptLike")
     */
    public function decryptLikeAction($id){

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("UkronicBundle:Decrypt");
        // vérifier existence dans la BDD Ukronic
        $decrypt = $repository->findOneById($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($decrypt) {
            $nbLiked = $decrypt->getNbLiked();
            $decrypt->setNbLiked($nbLiked + 1);
            $em->persist($decrypt); // sauvegarde le cpt de lectures du 
            $beloved = new Beloved();
            $beloved->setDecrypt($decrypt);
            $beloved->setUser($user);
            $beloved->setDateLike(new \DateTime('now'));
            $em->persist($beloved);

            $histo = new Histo();
            $histo->setUser($user);
            $histo->setAction(2);
            $histo->setDateAction(new \DateTime('now'));
            $histo->setReference($decrypt->getId());
            $em->persist($histo);

            $em->flush();
        }

        //return $this->render("UkronicBundle:ukronic:decryptDisplay.html.twig", array("decrypt"=>$decrypt,"liked" =>true));
        return $this->redirectToRoute('decryptRead',array("id"=>$decrypt->getId()));
    }

}
