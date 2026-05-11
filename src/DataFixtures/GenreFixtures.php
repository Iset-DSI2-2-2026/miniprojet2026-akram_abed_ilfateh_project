<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genres = [
            'Roman' => '#FF5733',
            'Science-Fiction' => '#33FF57',
            'Policier' => '#3357FF',
            'Fantasy' => '#FF33F5',
            'Biographie' => '#F5FF33',
            'Histoire' => '#33FFF5',
        ];

        foreach ($genres as $nom => $couleur) {
            $genre = new Genre();
            $genre->setNom($nom);
            $genre->setCouleur($couleur);
            $genre->setDescription($nom . ' - ' . 'Livres de ' . $nom);
            $manager->persist($genre);
            $this->addReference('genre_' . $nom, $genre);
        }

        $manager->flush();
    }
}
