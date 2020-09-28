<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

     /**
      * @return Article[] Returns an array of Article objects
      */
    public function findBySousCategorie($cat=null, $search,$length,$start)
    {
         $qb =$this->createQueryBuilder('a');
         if($cat!=null){
             $qb->andWhere('a.sousCategorie = :cat')
                 ->setParameter('cat', $cat);
         }
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
    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findPromotion(){
        return $this->createQueryBuilder('a')
            ->andWhere('a.promotion > :val')
            ->setParameter('val',1 )
            ->getQuery()
            ->getResult();
    }
    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
