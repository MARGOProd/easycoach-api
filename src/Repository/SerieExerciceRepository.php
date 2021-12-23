<?php

namespace App\Repository;

use App\Entity\SerieExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerieExercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerieExercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerieExercice[]    findAll()
 * @method SerieExercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerieExercice::class);
    }

    // /**
    //  * @return SerieExercice[] Returns an array of SerieExercice objects
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
    public function findOneBySomeField($value): ?SerieExercice
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
