<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        //Utilisation de faker
        $faker = \Faker\Factory::create('fr_FR');
        //Création d'un administrateur
        $userAdmin = new User();
        $userAdmin->setFirstName('admin');
        $userAdmin->setLastName('admin');
        $userAdmin->setEmail('admin@test.fr');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $password=$this->userPasswordHasher->hashPassword($userAdmin, '123456');
        $userAdmin->setPassword($password);
        $manager->persist($userAdmin);

        //Création d'un utilisateur qui a le role d'un plannificateur.
        $userPlanner = new User();
        $userPlanner->setFirstName('planner');
        $userPlanner->setLastName('planner');
        $userPlanner->setEmail('planner@test.fr');
        $userPlanner->setRoles(['ROLE_PLANNER']);
        $password=$this->userPasswordHasher->hashPassword($userPlanner, '123456');
        $userPlanner->setPassword($password);
        $manager->persist($userPlanner);

        //Créer 10 Utilisateurs classiques
        for($i = 1; $i <= 10; $i++){
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setEmail("user$i@test.fr");
            $user->setRoles(['ROLE_USER']);
            $password=$this->userPasswordHasher->hashPassword($userAdmin, '123456');
            $user->setPassword($password);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
