<?php

namespace App\Repository;

use App\Entity\sousCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method sousCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method sousCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method sousCategorie[]    findAll()
 * @method sousCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, sousCategorie::class);
    }

     /**
      * @return SousCategorie[] Returns an array of SousCategorie objects
      */

    public function findByCategorie($categorie=null)
    {
        $qb=$this->createQueryBuilder('c');
        if ($categorie!=null)
        {
            $qb ->andWhere('c.categorie = :val')
                ->setParameter('val', $categorie);
        }
        return $qb->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?SousCategorie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
