<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Receipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un utilisateur
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setName('Doe');
        $user->setFirstName('John');
        $user->setAdress('123 Main St');

        // Hasher le mot de passe (exemple : "password")
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($hashedPassword);

        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        // Création d'une recette liée à cet utilisateur
        $receipe = new Receipe();
        $receipe->setName('Tarte aux pommes');
        $receipe->setDescription('Délicieuse tarte aux pommes maison');
        $receipe->setPreparationTime(30.0);
        $receipe->setCookingTime('45');
        $receipe->setDifficulty('Moyen');
        $receipe->setCategory(['Dessert', 'Pâtisserie']);
        $receipe->setImage('tarte.jpg');
        $receipe->setCoast(10);
        $receipe->setKeyword(['pommes', 'sucré', 'four']);
        $receipe->setAuthor($user);

        $manager->persist($receipe);

        $manager->flush();
    }
}
