<?php

namespace App\Repository;

use App\Entity\SeanceUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SeanceUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeanceUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeanceUser[]    findAll()
 * @method SeanceUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeanceUser::class);
    }

    // /**
    //  * @return SeanceUser[] Returns an array of SeanceUser objects
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
    public function findOneBySomeField($value): ?SeanceUser
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
