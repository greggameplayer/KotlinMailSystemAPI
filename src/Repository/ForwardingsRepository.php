<?php

namespace App\Repository;

use App\Entity\Forwardings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Forwardings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forwardings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forwardings[]    findAll()
 * @method Forwardings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForwardingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forwardings::class);
    }

    // /**
    //  * @return Forwardings[] Returns an array of Forwardings objects
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
    public function findOneBySomeField($value): ?Forwardings
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
