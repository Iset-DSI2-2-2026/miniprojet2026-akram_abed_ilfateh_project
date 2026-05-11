<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AuteurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        $auteurs = [
            ['nom' => 'Hugo', 'prenom' => 'Victor', 'nationalite' => 'Française'],
            ['nom' => 'Dumas', 'prenom' => 'Alexandre', 'nationalite' => 'Française'],
            ['nom' => 'Orwell', 'prenom' => 'George', 'nationalite' => 'Anglaise'],
            ['nom' => 'Rowling', 'prenom' => 'J.K.', 'nationalite' => 'Anglaise'],
            ['nom' => 'Christie', 'prenom' => 'Agatha', 'nationalite' => 'Anglaise'],
        ];

        $i = 1;
        foreach ($auteurs as $data) {
            $auteur = new Auteur();
            $auteur->setNom($data['nom']);
            $auteur->setPrenom($data['prenom']);
            $auteur->setNationalite($data['nationalite']);
            $auteur->setBiographie($faker->paragraph(2));
            $manager->persist($auteur);
            $this->addReference('auteur_' . $i, $auteur);
            $i++;
        }

        $manager->flush();
    }
}
