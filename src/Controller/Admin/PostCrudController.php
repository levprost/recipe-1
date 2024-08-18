<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Step1;
use App\Entity\PostHasIngredient;
use App\Form\Step1Type;
use App\Form\PostHasIngredientType;
use App\Form\IngredientType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),

            TextField::new('title')->setColumns('col-md-6'),

            TextField::new('abstract')->setColumns('col-md-6'),

            IntegerField::new('prepTime')->setColumns('col-md-6'),

            $image = ImageField::new('image')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/images')
                ->setSortable(false)
                ->setFormTypeOption('required', false)->setColumns('col-md-2'),
            
            /*DateTimeField::new('prepTime')
                ->setLabel('Preparation Time')
                ->setFormat('yyyy-MM-dd HH:mm')
                ->setRequired(false)
                ->setColumns('col-md-2'),
            */
            AssociationField::new('rubrik')->setColumns('col-md-4'),
            
            AssociationField::new('user')->setColumns('col-md-6'),
            
            // Ajouter la collection des étapes

            CollectionField::new('step1s')
                ->setEntryType(Step1Type::class)
                ->allowAdd(true)  // Allow adding new steps
                ->allowDelete(true)  // Allow deleting steps
                ->setColumns('col-md-12')
                ->onlyOnForms(),
            DateField::new('createdAt')
            ->setLabel('Created At'),

             // Ingredients section
             FormField::addPanel('Ingredient'),
             CollectionField::new('PostHasIngredient')
                 ->setEntryType(PostHasIngredientType::class)
                 ->allowAdd(true)
                 ->allowDelete(true)
                 ->setColumns('col-md-12')
                 ->onlyOnForms(),
            //on n'est pas obligé de mettre le set Permission. Pourquoi?

            $Published = BooleanField::new('isPublished')->setPermission('ROLE_ADMIN')->setcolumns('col-md-1')->setLabel('Publié'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Post') 
            ->setDefaultSort(['createdAt'=>'DESC'])
            ->setPaginatorPageSize(5)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('user')
            ->add('title')
            ->add('rubrik')
            //->add('CreatedAt')
    ;

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE,'ROLE_ADMIN')
        ;
    }
    
}
