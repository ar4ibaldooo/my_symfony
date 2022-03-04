<?php

namespace App\Controller\Admin;

use App\Entity\Note;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use function EasyCorp\Bundle\EasyAdminBundle\Field\onlyOnDetail;

class NoteCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Note::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->disable(Action::NEW)
            ->disable(Action::DELETE)
            ->disable(Action::EDIT);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            EmailField::new('email'),
            TextField::new('text'),
            TextField::new('formes'),
            TextField::new('colors'),


             CollectionField::new('images', 'Image(s)')
                 ->setEntryType(ImageType::class)
                 ->onlyOnDetail()
                 ->setFormTypeOptions([
                     'by_reference' => false,
                     'entry_options' => ['label' => false],
                     'setBasePath' => '/uploads/image'
                 ]),

             CollectionField::new('images')
                 ->setTemplatePath('admin/images.html.twig')





            /*            ImageField::new('images')
                ->setBasePath('/uploads/image'),*/
            /*     ArrayField::new('images'),
                 CollectionField::new('images')->setEntryType(ImageField::class),*/
/*            ImageField::new('imageName', 'Image')
                ->onlyOnIndex()
                ->setBasePath('/public/uploads/image'),
            ImageField::new('imageFile', 'Image')
                ->onlyOnForms()
                ->setFormType(VichImageType::class)*/

        ];
    }

}
