<?php

namespace App\Repository;

use App\Entity\SeanceSerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SeanceSerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeanceSerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeanceSerie[]    findAll()
 * @method SeanceSerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceSerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeanceSerie::class);
    }

    // /**
    //  * @return SeanceSerie[] Returns an array of SeanceSerie objects
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
    public function findOneBySomeField($value): ?SeanceSerie
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
