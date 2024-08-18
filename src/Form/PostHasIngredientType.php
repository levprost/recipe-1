<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Post;
use App\Entity\PostHasIngredient;
use App\Entity\Unit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\TexType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostHasIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('ingredient', EntityType::class, [
            'class' => Ingredient::class,
            'choice_label' => 'name',
            'placeholder' => 'Choose or type new ingredient',
            'required' => false,
        ])
        ->add('quantity', TextType::class, [
            'label' => 'Quantity',
        ])
        ->add('unit', EntityType::class, [
            'class' => Unit::class,
            'choice_label' => 'unity',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostHasIngredient::class,
        ]);
    }
}
