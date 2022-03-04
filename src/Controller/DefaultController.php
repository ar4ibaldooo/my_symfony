<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityRepository;
use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class DefaultController extends AbstractController
{
    public function index(): Response
    {



        // возвращает ваш объект User или null, если пользователь не аутентифицирован
        // использовать встроенную документацию, чтобы сообщить вашему редактору ваш точный класс User
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Вызвать те методы, которые вы добавили в ваш класс User
        // Например, если вы добавили метод getFirstName(), вы можете использовать его.

        return $this->render('default/index.html.twig', [
            'userName' => $user,
        ]);
    }
}