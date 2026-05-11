<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tags = [
            'Bestseller' => '#FF0000',
            'Classique' => '#0000FF',
            'Coup de coeur' => '#FFD700',
            'Nouveau' => '#00FF00',
            'Prix littéraire' => '#800080',
            'Film adapté' => '#FF8C00',
            'Collection' => '#008080',
            'Édition limitée' => '#FF69B4',
        ];

        foreach ($tags as $nom => $couleur) {
            $tag = new Tag();
            $tag->setNom($nom);
            $tag->setCouleur($couleur);
            $manager->persist($tag);
            $this->addReference('tag_' . $nom, $tag);
        }

        $manager->flush();
    }
}
