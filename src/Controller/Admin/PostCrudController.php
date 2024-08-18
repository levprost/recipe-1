<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\PostHasIngredient;
use App\Form\PostHasIngredientType;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
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

            TextField::new('prepaTime')->setColumns('col-md-6'),

            $image = ImageField::new('image')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/images')
                ->setSortable(false)
                ->setFormTypeOption('required', false)->setColumns('col-md-2'),
            
            AssociationField::new('rubrik')->setColumns('col-md-4'),

            AssociationField::new('user')->setColumns('col-md-6'),
    
            DateField::new('createdAt')->onlyOnIndex(),
            

            CollectionField::new('postHasIngredient')
            ->setEntryType(PostHasIngredientType::class)
            ->onlyOnForms(),
            FormField::addPanel('Ingredients')->setFormType(PostHasIngredientType::class),

            //on n'est pas obligé de mettre le set Permission. Pourquoi?
            
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
