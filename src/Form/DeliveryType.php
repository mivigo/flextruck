<?php

namespace App\Form;

use App\Entity\Delivery;
use App\Entity\Route;
use App\Entity\Truck;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\Query\Expr\Select;
use Faker\Provider\DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client_name', TextType::class, ['label' => 'Client Name'])
            ->add('client_address', TextType::class, ['label' => 'Client Address'])
            ->add('delivery_time', DateType::class, [
                'label' => 'Delivery time',
                'widget' => 'single_text'
            ])
            ->add('latitude', NumberType::class, ['label' => 'Latitude'])
            ->add('longtitude', NumberType::class, ['label' => 'longitude'])
            ->add('route', EntityType::class, [
                'class' => Route::class,
                'placeholder' => 'Choose a Route',
                'choice_label' => 'id'
            ])
            ->add('done', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Delivery::class,
        ]);
    }
}
