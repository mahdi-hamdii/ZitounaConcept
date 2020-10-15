<?php

namespace App\Repository;

use App\Entity\CatalogArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CatalogArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatalogArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatalogArticle[]    findAll()
 * @method CatalogArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatalogArticle::class);
    }

    // /**
    //  * @return CatalogArticle[] Returns an array of CatalogArticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CatalogArticle
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
