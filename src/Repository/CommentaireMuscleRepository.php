<?php

namespace App\Repository;

use App\Entity\CommentaireMuscle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentaireMuscle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireMuscle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireMuscle[]    findAll()
 * @method CommentaireMuscle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireMuscleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireMuscle::class);
    }

    // /**
    //  * @return CommentaireMuscle[] Returns an array of CommentaireMuscle objects
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
    public function findOneBySomeField($value): ?CommentaireMuscle
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
