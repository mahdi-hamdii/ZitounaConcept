<?php

namespace App\Repository;

use App\Entity\SousService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SousService|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousService|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousService[]    findAll()
 * @method SousService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousService::class);
    }

    // /**
    //  * @return SousService[] Returns an array of SousService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SousService
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
