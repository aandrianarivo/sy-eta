<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Receipe;
use App\Entity\DailyMeal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création utilisateur
        $user = new User();
        $user->setEmail('user@example.com');
        $user->setName('Dupont');
        $user->setFirstName('Jean');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('password'); // Attention : en vrai, il faut hasher le mdp !
        $manager->persist($user);

        // Création recette 1
        $receipe1 = new Receipe();
        $receipe1->setName('Poulet Rôti');
        $receipe1->setDescription('Délicieux poulet rôti au four.');
        $receipe1->setImage('poulet.jpg');
        $receipe1->setAuthor($user);
        $manager->persist($receipe1);

        // Création recette 2
        $receipe2 = new Receipe();
        $receipe2->setName('Salade Verte');
        $receipe2->setDescription('Salade fraîche avec vinaigrette maison.');
        $receipe2->setImage('salade.jpg');
        $receipe2->setAuthor($user);
        $manager->persist($receipe2);

        // Création repas matin
        $morningMeal = new DailyMeal();
        $morningMeal->setMealDate(new \DateTime('today'));
        $morningMeal->addReceipe($receipe1);
        $morningMeal->setAuthor($user);
        $manager->persist($morningMeal);

        // Création repas midi
        $noonMeal = new DailyMeal();
        $noonMeal->setMealDate(new \DateTime('today'));
        $noonMeal->addReceipe($receipe1);
        $noonMeal->addReceipe($receipe2);
        $noonMeal->setAuthor($user);
        $manager->persist($noonMeal);

        // Création repas soir
        $eveningMeal = new DailyMeal();
        $eveningMeal->setMealDate(new \DateTime('today'));
        $eveningMeal->addReceipe($receipe2);
        $eveningMeal->setAuthor($user);
        $manager->persist($eveningMeal);

        $manager->flush();
    }
}
