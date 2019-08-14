<?php

namespace App\Form;

use App\Entity\Truck;
use phpDocumentor\Reflection\Types\Float_;
use PhpParser\Node\Expr\Cast\Double;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TruckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registration', TextType::class, ['label' => 'Registration'])
            ->add('vendor', TextType::class, ['label' => 'Vendor'])
            ->add('model', TextType::class, ['label' => 'Truck Model'])
            ->add('weight', NumberType::class, ['label' => 'Weight'])
            ->add('length', NumberType::class, ['label' => 'Length'])
            ->add('height', NumberType::class, ['label' => 'Height'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Truck::class,
        ]);
    }
}
