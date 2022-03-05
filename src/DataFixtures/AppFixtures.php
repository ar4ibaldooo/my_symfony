<?php

namespace App\DataFixtures;

use Cocur\Slugify\Slugify;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

 class AppFixtures extends Fixture
 {
     public function load(ObjectManager $manager)
     {
         // create 20 products! Bam!
         for ($i = 0; $i < 20; $i++) {
             $product = new Product();
             $product->setName('product '.$i);
             $product->setPrice(mt_rand(10, 100));
             $manager->persist($product);
         }
         $manager->flush();
     }
 }


