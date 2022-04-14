<?php

namespace App\Repository;

use App\Entity\SeanceMarque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SeanceMarque|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeanceMarque|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeanceMarque[]    findAll()
 * @method SeanceMarque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceMarqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeanceMarque::class);
    }

    // /**
    //  * @return SeanceMarque[] Returns an array of SeanceMarque objects
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
    public function findOneBySomeField($value): ?SeanceMarque
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
