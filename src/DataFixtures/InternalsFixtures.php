<?php

namespace App\DataFixtures;

use Cocur\Slugify\Slugify;
use App\Entity\User;
use App\Entity\Note;
use App\Entity\Image;
use App\Entity\Color;
use App\Entity\Form;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

 class InternalsFixtures extends Fixture
 {
     public const colorConst = 'цвет';
     public const formConst = 'форма';
     public static function getReferenceKeyColor($i){
         return sprintF('post_color_%s', $i);
     }
     public static function getReferenceKeyForm($i){
         return sprintF('post_form_%s', $i);
     }


     public function load(ObjectManager $manager)
     {

         ///color
         $colornames= array('синий','красный','зеленый','фиолетовый');
         $i =2;

         for ($i  = 0; $i < count($colornames); $i++){

             $color = new Color();
             $color->setColor($colornames[$i]);
             $manager->persist($color);
             $this->addReference(self::getReferenceKeyColor($i),$color);
             /*$this->addReference(self::colorConst, $color);*/
         }
         ///form

       $formnames= array('квадрат','треугольник','ромб','круг');
          for ($i  = 0; $i < count($formnames); $i++){

             $form = new Form();
             $form->setForm($formnames[$i]);
             $manager->persist($form);
             /*$this->addReference(self::formConst,$form);*/
             $this->addReference(self::getReferenceKeyForm($i),$form);
         }
         $manager->flush();
     }

 }


