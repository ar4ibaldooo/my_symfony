<?php

namespace App\Controller\Admin;

use App\Entity\Note;
use App\Entity\Image;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        /*return parent::index();*/
        return $this->render('admin/index.html.twig');
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EasyAdminBundleTest');
    }
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToURL('Return homepage', 'fas fa-home', 'note');
        yield MenuItem::linkToCrud('User', 'fa fa-address-book', User::class);
        yield MenuItem::linkToURL('NEW User++', 'fa fa-address-book', 'register');
        yield MenuItem::linkToCrud('Note', 'fa fa-comment-o', Note::class);
        /*yield MenuItem::linkToCrud('Image', 'fa fa-comment-o', Image::class);*/
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
 }
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user);
    }
}

