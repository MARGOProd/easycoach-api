<?php

namespace App\Repository;

use App\Entity\ExerciceCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExerciceCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciceCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciceCategorie[]    findAll()
 * @method ExerciceCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciceCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciceCategorie::class);
    }

    // /**
    //  * @return ExerciceCategorie[] Returns an array of ExerciceCategorie objects
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
    public function findOneBySomeField($value): ?ExerciceCategorie
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
