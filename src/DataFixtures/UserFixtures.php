<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        // Admin (user_1)
        $admin = new User();
        $admin->setEmail('admin@bookshelf.com');
        $admin->setPseudo('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);
        $this->addReference('user_1', $admin);

        // Bibliothecaire (user_2)
        $biblio = new User();
        $biblio->setEmail('biblio@bookshelf.com');
        $biblio->setPseudo('bibliothecaire');
        $biblio->setRoles(['ROLE_BIBLIOTHECAIRE']);
        $biblio->setPassword($this->passwordHasher->hashPassword($biblio, 'biblio123'));
        $manager->persist($biblio);
        $this->addReference('user_2', $biblio);

        // 5 normal users (user_3 to user_7)
        for ($i = 3; $i <= 7; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPseudo($faker->userName());
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'user123'));
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
