<?php

namespace App\Repository;

use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function findByFilters(?string $titre, ?Genre $genre, ?bool $disponible, ?Tag $tag): array
    {
        $qb = $this->createQueryBuilder('l')
            ->leftJoin('l.auteur', 'a')
            ->leftJoin('l.genre', 'g')
            ->leftJoin('l.tags', 't');

        if ($titre) {
            $qb->andWhere('l.titre LIKE :titre')
               ->setParameter('titre', '%' . $titre . '%');
        }
        
        if ($genre) {
            $qb->andWhere('l.genre = :genre')
               ->setParameter('genre', $genre);
        }
        
        if ($disponible !== null) {
            $qb->andWhere('l.disponible = :dispo')
               ->setParameter('dispo', $disponible);
        }
        
        if ($tag) {
            $qb->andWhere('t = :tag')
               ->setParameter('tag', $tag);
        }

        return $qb->orderBy('l.datePublication', 'DESC')
                  ->getQuery()
                  ->getResult();
    }

    public function findLastAdded(int $limit = 5): array
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
