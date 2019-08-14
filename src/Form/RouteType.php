<?php

namespace App\Form;

use App\Entity\Route;
use App\Entity\Truck;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('route_title', TextType::class, ['label' => 'Route'])
            ->add('start_time', DateType::class, [
                'label' => 'Start time',
                'widget' => 'single_text'
            ])
            ->add('end_time', DateType::class, [
                'label' => 'Start time',
                'widget' => 'single_text'
            ])
            ->add('truck', EntityType::class, [
                'class' => Truck::class,
                'placeholder' => 'Choose a Truck',
                'choice_label' => 'id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Route::class,
        ]);
    }
}
