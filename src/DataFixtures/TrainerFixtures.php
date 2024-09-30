<?php

namespace App\DataFixtures;

use App\Entity\Trainer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrainerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        //Utilisation de faker
        $faker = \Faker\Factory::create('fr_FR');
        //Création de 20 Trainer complémentaires avec Faker
        for($i=1;$i<=20;$i++){
            $trainer = new Trainer();
            $trainer->setFirstName($faker->firstName());
            $trainer->setLastName($faker->lastName());
            $trainer->setDateCreated(new \DateTimeImmutable());
            $this->addReference('trainer'.$i, $trainer);
            $manager->persist($trainer);
        }
        $manager->flush();
    }
}
