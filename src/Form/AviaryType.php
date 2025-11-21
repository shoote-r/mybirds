<?php

namespace App\Form;

use App\Entity\Aviary;
use App\Repository\BirdsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AviaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // On récupère la galerie en cours d'édition
        $aviary = $options['data'] ?? null;
        $member = $aviary?->getMember();
        
        $builder
        ->add('description')
        ->add('published')
        ->add('member', null, [
            'disabled' => true,
        ])
        ->add('birds', null, [
            // Permet à Symfony d'appeler setBirds() au lieu de setBirdsCollection()
            'by_reference' => false,
            // Sélection multiple
            'multiple' => true,
            // Affichage en cases à cocher
            'expanded' => true,
            // Filtrer les birds : uniquement ceux appartenant au member
            'query_builder' => function (BirdsRepository $er) use ($member) {
            return $er->createQueryBuilder('b')
            ->leftJoin('b.garden', 'g')
            ->leftJoin('g.member', 'm')
            ->andWhere('m.id = :memberId')
            ->setParameter('memberId', $member->getId());
            },
            ])
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aviary::class,
        ]);
    }
}
