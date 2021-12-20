<?php

namespace App\Repository;

use App\Entity\SanitaryHotwater;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SanitaryHotwater|null find($id, $lockMode = null, $lockVersion = null)
 * @method SanitaryHotwater|null findOneBy(array $criteria, array $orderBy = null)
 * @method SanitaryHotwater[]    findAll()
 * @method SanitaryHotwater[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SanitaryHotwaterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SanitaryHotwater::class);
    }

    // /**
    //  * @return SanitaryHotwater[] Returns an array of SanitaryHotwater objects
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
    public function findOneBySomeField($value): ?SanitaryHotwater
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
