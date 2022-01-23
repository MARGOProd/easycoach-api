<?php

namespace App\Repository;

use App\Entity\GroupeMusculaire;
use App\Entity\Muscle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Muscle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Muscle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Muscle[]    findAll()
 * @method Muscle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MuscleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Muscle::class);
    }

    // /**
    //  * @return Muscle[] Returns an array of Muscle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findMuscleAndGroupeMusculaire()
    {
        $queryBuilder = $this->createQueryBuilder('muscle');
            $queryBuilder->select('muscle');
            // $queryBuilder->join('muscle.groupe_musculaire', 'groupe_muclaire');
            $queryBuilder->groupBy('groupeMusculaire.id');
        $queryBuilder->setMaxResults(7);
        dump($queryBuilder->getQuery());
        exit();
        return $queryBuilder->getQuery()->getResult();
    }
}
