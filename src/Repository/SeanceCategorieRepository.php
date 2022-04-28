<?php

namespace App\Repository;

use App\Entity\SeanceCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SeanceCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeanceCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeanceCategorie[]    findAll()
 * @method SeanceCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeanceCategorie::class);
    }

    // /**
    //  * @return SeanceCategorie[] Returns an array of SeanceCategorie objects
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
    public function findOneBySomeField($value): ?SeanceCategorie
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
