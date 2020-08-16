<?php

namespace App\Repository;

use App\Entity\IsInWatchlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IsInWatchlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method IsInWatchlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method IsInWatchlist[]    findAll()
 * @method IsInWatchlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IsInWatchlistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IsInWatchlist::class);
    }

    // /**
    //  * @return IsInWatchlist[] Returns an array of IsInWatchlist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IsInWatchlist
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
