<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // ne jamais oublier d'importer les class que l'on utilise
        // prendre toujours les composant de symfony et pas doctrine
        $builder
            ->add('raisonSociale', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('dateCreation', DateType::class, [
                'widget' =>'single_text',
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('cp', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            ->add('ville', TextType::class, [
                'attr'=> [
                    'class'=> 'form-control'
                ]
            ])
            // et on ajoute un SubmitType pour Valider le formulaire et on importe egalement SubmitType
            ->add('valider', SubmitType::class, [
                'attr'=> [
                    'class'=>'btn btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
