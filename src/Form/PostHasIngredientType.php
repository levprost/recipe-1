<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Post;
use App\Entity\PostHasIngredient;
use App\Entity\Unit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostHasIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            ->add('ingredient')
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
