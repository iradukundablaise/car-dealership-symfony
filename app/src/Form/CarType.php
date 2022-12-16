<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'required' => true,
                'label' => 'Car name'
            ])
            ->add('nbSeats', null, [
                'required' => true,
                'label' => 'Number of seats'
            ])
            ->add('nbDoors', null, [
                'required' => true,
                'label' => 'Number of doors'
            ])
            ->add('cost', null, [
                'required' => true,
            ])
            ->add('category', EntityType::class, [
                'class' => CarCategory::class,
                'choice_label' => 'name',
                'required' => true,
                'label' => 'Car category'
            ])
            ->add('save', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
