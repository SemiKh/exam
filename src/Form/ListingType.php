<?php

namespace App\Form;

use App\Entity\Listing;
use App\Entity\Model;
use App\Repository\ModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('producedYear')
            ->add('mileage')
            ->add('price')
            ->add('image', FileType::class)
            ->add('model', EntityType::class, [
                'label' => 'Model',
                'class' => Model::class,
                'choice_label' => 'name',
                'query_builder' => function (ModelRepository $mr) {
                    return $mr->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
