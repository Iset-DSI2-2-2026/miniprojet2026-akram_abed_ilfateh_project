<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Tag;
use App\Entity\User;

class LivreFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        // Get all authors (5 authors)
        $auteurs = [];
        for ($i = 1; $i <= 5; $i++) {
            $auteurs[] = $this->getReference('auteur_' . $i, Auteur::class);
        }
        
        // Get all genres (6 genres)
        $genres = [];
        $genreNames = ['Roman', 'Science-Fiction', 'Policier', 'Fantasy', 'Biographie', 'Histoire'];
        foreach ($genreNames as $name) {
            $genres[] = $this->getReference('genre_' . $name, Genre::class);
        }
        
        // Get all tags (8 tags)
        $tags = [];
        $tagNames = ['Bestseller', 'Classique', 'Coup de coeur', 'Nouveau', 'Prix littéraire', 'Film adapté', 'Collection', 'Édition limitée'];
        foreach ($tagNames as $name) {
            $tags[] = $this->getReference('tag_' . $name, Tag::class);
        }
        
        // Get all users (7 users)
        $users = [];
        for ($i = 1; $i <= 7; $i++) {
            $users[] = $this->getReference('user_' . $i, User::class);
        }

        // Create 30 books
        for ($i = 1; $i <= 30; $i++) {
            $livre = new Livre();
            $livre->setTitre($faker->sentence(3));
            $livre->setResume($faker->paragraph(4));
            $livre->setIsbn($faker->isbn13());
            $livre->setNbPages($faker->numberBetween(50, 800));
            $livre->setDatePublication($faker->dateTimeBetween('-50 years', 'now'));
            $livre->setDisponible($faker->boolean(80));
            $livre->setAuteur($faker->randomElement($auteurs));
            $livre->setGenre($faker->randomElement($genres));
            $livre->setAjoutePar($faker->randomElement($users));
            
            // Add random tags (1 to 4 tags)
            $randomTags = $faker->randomElements($tags, $faker->numberBetween(1, 4));
            foreach ($randomTags as $tag) {
                $livre->addTag($tag);
            }
            
            $manager->persist($livre);
        }

        $manager->flush();
    }
    
    public function getDependencies(): array
    {
        return [
            GenreFixtures::class,
            TagFixtures::class,
            AuteurFixtures::class,
            UserFixtures::class,
        ];
    }
}
