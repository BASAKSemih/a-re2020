<?php

namespace App\Repository;

use App\Entity\Carpentry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Carpentry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carpentry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carpentry[]    findAll()
 * @method Carpentry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarpentryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carpentry::class);
    }

    // /**
    //  * @return Carpentry[] Returns an array of Carpentry objects
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
    public function findOneBySomeField($value): ?Carpentry
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
