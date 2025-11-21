<?php

namespace App\Form;

use App\Entity\Birds;
use App\Entity\Garden;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BirdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name')
        ->add('description')
        ->add('garden', null, [
            'disabled' => true,
        ])
        ->add('imageFile', FileType::class, [
            'label' => 'Image de l’oiseau (JPEG, PNG, GIF)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '2048k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                    ],
                    'mimeTypesMessage' => 'Veuillez envoyer une image valide (JPEG, PNG ou GIF)',
                ])
            ],
        ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Birds::class,
        ]);
    }
}
