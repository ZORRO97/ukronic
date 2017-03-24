<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use UkronicBundle\Entity\Recherche;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserController extends Controller
{
    

    /**
    * @Route("/imageUser", name = "imageUser")
    */
    public function imageUserAction(Request $request){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $form = $this->createFormBuilder($user)
        ->add('imageFile',FileType::class)
        ->add('save', SubmitType::class, array('label' => "Modifier l'image"))
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('profile');
        }
        return $this->render("UkronicBundle:User:imageUser.html.twig",array(
                "form" => $form->createView(),
                "user" => $user
            ));
    }

    /**
     * @Route("/Banner",name="UkronicBanner")
     */
    public function bannerAction(Request $request){

        $recherche = new Recherche();
        $form = $this->createFormBuilder($recherche)
                    ->setAction($this->generateUrl('ukronic-recherche'))
                    ->add('title', TextType::class)                    
                    ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        
            $recherche = $form->getData();
            
            
            return $this->redirectToRoute('movieSearch');      
        }
        
        return $this->render("UkronicBundle:User:banner.html.twig",array('form'=>$form->createView()));
    }

}
