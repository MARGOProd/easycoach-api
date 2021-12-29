<?php

namespace App\Repository;

use App\Entity\ClientData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientData[]    findAll()
 * @method ClientData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientData::class);
    }

    // /**
    //  * @return ClientData[] Returns an array of ClientData objects
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
    public function findOneBySomeField($value): ?ClientData
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
