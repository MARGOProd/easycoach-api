<?php

namespace App\Repository;

use App\Entity\Frequence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Frequence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Frequence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Frequence[]    findAll()
 * @method Frequence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FrequenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Frequence::class);
    }

    // /**
    //  * @return Frequence[] Returns an array of Frequence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Frequence
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
