<?php

namespace App\Controller\Admin;

use App\Entity\Chat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ChatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chat::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('admin'),
            DateTimeField::new('deletedAt'),
        ];
    }
}
