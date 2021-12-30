<?php

namespace App\Repository;

use App\Entity\ExerciceMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExerciceMateriel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciceMateriel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciceMateriel[]    findAll()
 * @method ExerciceMateriel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciceMaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciceMateriel::class);
    }

    // /**
    //  * @return ExerciceMateriel[] Returns an array of ExerciceMateriel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExerciceMateriel
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
