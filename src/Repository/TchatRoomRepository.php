<?php

namespace App\Repository;

use App\Entity\TchatRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TchatRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method TchatRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method TchatRoom[]    findAll()
 * @method TchatRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TchatRoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TchatRoom::class);
    }

    // /**
    //  * @return TchatRoom[] Returns an array of TchatRoom objects
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
