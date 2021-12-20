<?php

namespace App\Repository;

use App\Entity\SecondaryHeading;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SecondaryHeading|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecondaryHeading|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecondaryHeading[]    findAll()
 * @method SecondaryHeading[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecondaryHeadingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecondaryHeading::class);
    }

    // /**
    //  * @return SecondaryHeading[] Returns an array of SecondaryHeading objects
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
    public function findOneBySomeField($value): ?SecondaryHeading
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
