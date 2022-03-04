<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Note;
use App\Form\NoteType;
use App\Form\MassageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityRepository;


class NoteController extends AbstractController
{
    #[Route('/note', name: 'note')]
    public function new(Request $request,  EntityManagerInterface  $entityManager, SluggerInterface $slugger): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
        $imageFiles = $form->get('images')->getData();

        if ($form->isSubmitted() && $form->isValid() &&  (count($imageFiles)>=1 && count($imageFiles)<=4)) {
            $note = $form->getData();
/*            $file= $note->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
            // This parameter should be configured
                $this->getParameter('image_directory'),
                $fileName
            );
            $note->setAvatar($fileName);*/


            /** @var UploadedFile $imageFiles */

                foreach($imageFiles as $imageFile){
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                    $img = new Image();
                    $img->setName($newFilename);
                    $note->addImage($img);

                }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();
            // do anything else you need here, like send an email
            //return new Response('Запись сохранена');

            /*return $this->redirectToRoute('note');*/
            $this->addFlash(
                'notice',
                'The data is stored, please click OK'
            );
        }
        Elseif($form->isSubmitted() && $form->isValid() &&  (count($imageFiles)>4)) {
            $this->addFlash(
                'notice',
                'Can\'t upload more than 4 images'
            );
        }
        $formMassage = $this->createForm(MassageType::class);
        $formMassage->handleRequest($request);
        if ($formMassage->isSubmitted()) {
            return $this->redirectToRoute('note');
        }
        // обычно вы хотите сначала убедиться, что пользователь аутентифивирован
        // см. "Authorization" ниже
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // возвращает ваш объект User или null, если пользователь не аутентифицирован
        // использовать встроенную документацию, чтобы сообщить вашему редактору ваш точный класс User
        /** @var \App\Entity\User $user */
        $userName = $this->getUser();


        return $this->render('note/note.html.twig', [
            'NoteType' => $form->createView(),
            'MassageType' => $formMassage->createView(),
            'userName' => $userName
        ]);
    }
    public function index(): Response
    {
        // обычно вы хотите сначала убедиться, что пользователь аутентифивирован
        // см. "Authorization" ниже
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // возвращает ваш объект User или null, если пользователь не аутентифицирован
        // использовать встроенную документацию, чтобы сообщить вашему редактору ваш точный класс User
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Вызвать те методы, которые вы добавили в ваш класс User
        // Например, если вы добавили метод getFirstName(), вы можете использовать его.
        return new Response('Hi '.$user->getUsername());
    }
}
