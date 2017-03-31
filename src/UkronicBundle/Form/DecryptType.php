<?php

namespace UkronicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DecryptType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            
            ->add('save', SubmitType::class, array('label' => 'Publier'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UkronicBundle\Entity\Decrypt'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ukronicbundle_decrypt';
    }


}
