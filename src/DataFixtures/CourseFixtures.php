<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture implements DependentFixtureInterface
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
        $course->setCategory($this->getReference('category1'));
        $this->addTrainers($course);
        $manager->persist($course);

        $coursPHP  = new Course();
        //hydrater toutes les propriétés.
        $coursPHP->setName('PHP');
        $coursPHP->setContent('Le développement web côté serveur');
        $coursPHP->setDuration(5);
        $coursPHP->setDateCreated(new \DateTimeImmutable());
        $coursPHP->setCategory($this->getReference('category1'));
        $coursPHP->setPublished(true);
        $this->addTrainers($coursPHP);
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
            $this->addTrainers($coursPHP);

            $coursPHP->setCategory($this->getReference('category'.mt_rand(1,2)));
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
            $this->addTrainers($coursPHP);
            $manager->persist($coursPHP);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            TrainerFixtures::class];
    }

    public function addTrainers(Course $course): void{
        for($i=0;$i<=mt_rand(0,5);$i++){
            $trainer = $this->getReference('trainer'.rand(1,20));
            $course->addTrainer($trainer);
        }
    }
}
