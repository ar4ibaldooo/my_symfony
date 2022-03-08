<?php

namespace App\DataFixtures;

use App\DataFixtures\InternalsFixtures;
use Cocur\Slugify\Slugify;
use App\Entity\User;
use App\Entity\Note;
use App\Entity\Image;
use App\Entity\Color;
use App\Entity\Form;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

 class AppFixtures extends Fixture implements DependentFixtureInterface
 {

     private $userPasswordHasherInterface;
     public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface)
     {
         $this->userPasswordHasherInterface = $userPasswordHasherInterface;
     }

     public function load(ObjectManager $manager)
     {
         ///user

         $user = new User();
         $user->setUsername('admin');
         $user->setRoles('ROLE_ADMIN');

         $user->setPassword(
             $this->userPasswordHasherInterface->hashPassword(
                 $user, "123456"
             )
         );
         $manager->persist($user);

         for ($i = 0; $i < 5; $i++) {
             $user = new User();
             $user->setUsername('user'.$i);
             $user->setRoles('ROLE_USER');
             $user->setPassword(
                 $this->userPasswordHasherInterface->hashPassword(
                     $user, "123456"
                 )
             );
             $manager->persist($user);
         }

         for ($i = 0; $i < 80; $i++) {
             $color = $this->getReference(InternalsFixtures::getReferenceKeyColor(rand(0, 3)));
             $form = $this->getReference(InternalsFixtures::getReferenceKeyForm(rand(0, 3)));
             $note = new Note();
             $img = new Image();
             $filename = $i.'.jpg';
             $email = 'ar4er'.$i.'@mail.ru';
             $text = 'vdklfdfdflfdfdflm';
             $note->addImage($img);
             $note->setEmail($email);
             $chars = substr(str_shuffle('0123456789 abcdef ghijklmn opqrstu vwxyz'), 0, 10);
             $note->setText($chars);
             $img->setName($filename);
             $note->addImage($img);
             if($color) {
                 $note->setColors($color);
             }
             if($form) {
                 $note->setFormes($form);
             }

             $manager->persist($note);
         }
         $manager->flush();
     }
     public function getDependencies()
     {
         return [
             InternalsFixtures::class,
         ];
     }
 }


