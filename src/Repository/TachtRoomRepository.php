<?php

namespace App\Repository;

use App\Entity\TachtRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TachtRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method TachtRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method TachtRoom[]    findAll()
 * @method TachtRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TachtRoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TachtRoom::class);
    }

    // /**
    //  * @return TachtRoom[] Returns an array of TachtRoom objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TachtRoom
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
