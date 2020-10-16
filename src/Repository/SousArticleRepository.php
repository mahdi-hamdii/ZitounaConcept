<?php

namespace App\Repository;

use App\Entity\SousArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SousArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousArticle[]    findAll()
 * @method SousArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousArticle::class);
    }
    public function findByFilter($search,$length,$start)
    {
        $qb =$this->createQueryBuilder('a');

        if ($search!=''){
            $qb
                ->andWhere("a.nom  like :search or a.dimension like :search or a.retour like :search")
                ->setParameter('search', ('%' . $search . '%'));
        }
        return $qb->setMaxResults($length)
            ->setFirstResult($start)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findPromotion(){
        return $this->createQueryBuilder('a')
            ->andWhere('a.promotion > :val')
            ->setParameter('val',1 )
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return SousArticle[] Returns an array of SousArticle objects
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
    public function findOneBySomeField($value): ?SousArticle
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
