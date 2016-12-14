<?php

namespace UkronicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UkronicBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends Controller
{
    /**
     * @Route("/Inscription")
     */
    public function InscriptionAction(Request $request)
    {
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('username',TextType::class)
            ->add('password',PasswordType::class)
            ->add('cgu', CheckboxType::class, array(
  			  'label'    => "J'accepte les Conditions Générales d'utilisation",
    			'required' => true,
    			'mapped' => false
				))
            ->add('captcha', IntegerType::class, array(
            	'mapped' => false, 
            	'label' => "12 + 27 =",
            	'required' => true
            	))
            ->add('save', SubmitType::class, array('label' => 'Créer mon compte'))
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
            $user = $form->getData();
            return $this->redirectToRoute('fos_user_registration_register',array('username'=>$user->getUsername(),'password'=>$user->getPassword(),'email'=>$user->getEmail()));
        

        
        }

        return $this->render('UkronicBundle:User:inscription.html.twig', array(
        	"form" => $form->createView(),
        	"user" => $user
            // ...
        ));
    }

}