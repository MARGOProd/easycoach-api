<?php

namespace App\Repository;

use App\Entity\UserMarque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserMarque|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMarque|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMarque[]    findAll()
 * @method UserMarque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMarqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserMarque::class);
    }

    // /**
    //  * @return UserMarque[] Returns an array of UserMarque objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserMarque
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
