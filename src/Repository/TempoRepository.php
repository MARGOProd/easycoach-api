<?php

namespace App\Repository;

use App\Entity\Tempo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tempo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tempo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tempo[]    findAll()
 * @method Tempo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tempo::class);
    }

    // /**
    //  * @return Tempo[] Returns an array of Tempo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tempo
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
