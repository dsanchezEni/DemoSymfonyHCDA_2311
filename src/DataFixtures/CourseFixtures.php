<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $course  = new Course();
        //hydrater toutes les propriétés.
        $course->setName('Symfony');
        $course->setContent('Le développement web côté serveur (avec Symfony)');
        $course->setDuration(10);
        $course->setDateCreated(new \DateTimeImmutable());
        $course->setPublished(true);
        $manager->persist($course);

        $coursPHP  = new Course();
        //hydrater toutes les propriétés.
        $coursPHP->setName('PHP');
        $coursPHP->setContent('Le développement web côté serveur');
        $coursPHP->setDuration(5);
        $coursPHP->setDateCreated(new \DateTimeImmutable());
        $coursPHP->setPublished(true);
        $manager->persist($coursPHP);

        //Création de 30 cours complémentaires
        for($i=1;$i<=30;$i++){
            $coursPHP  = new Course();
            //hydrater toutes les propriétés.
            $coursPHP->setName("Cours $i");
            $coursPHP->setContent("Description du cours $i");
            $coursPHP->setDuration(mt_rand(1,10));
            $coursPHP->setDateCreated(new \DateTimeImmutable());
            $coursPHP->setPublished(false);
            $manager->persist($coursPHP);
        }

        //Utilisation de faker
        $faker = \Faker\Factory::create('fr_FR');
        //Création de 30 cours complémentaires avec Faker
        for($i=1;$i<=30;$i++){
            $coursPHP  = new Course();
            //hydrater toutes les propriétés.
            $coursPHP->setName($faker->word());
            $coursPHP->setContent($faker->realText());
            $coursPHP->setDuration(mt_rand(1,10));
            //Ici dateCreated est une DateTime
            $dateCreated=$faker->dateTimeBetween('-2 months','now');
            //Je dois convertir mon DateTime en DateTimeImmutable
            $coursPHP->setDateCreated(\DateTimeImmutable::createFromMutable($dateCreated));

            $dateModified=$faker->dateTimeBetween($course->getDateCreated()->format('Y-m-d'),'now');
            $coursPHP->setDateModified(\DateTimeImmutable::createFromMutable($dateModified));
            $coursPHP->setPublished(false);
            $manager->persist($coursPHP);
        }

        $manager->flush();
    }
}
