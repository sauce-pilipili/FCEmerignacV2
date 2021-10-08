<?php

namespace App\Repository;

use App\Entity\MatchAVenir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MatchAVenir|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchAVenir|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchAVenir[]    findAll()
 * @method MatchAVenir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchAVenirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchAVenir::class);
    }

    // /**
    //  * @return MatchAVenir[] Returns an array of MatchAVenir objects
    //  */

    public function findAllMatchToPlay()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.matchDate > :val')
            ->setParameter('val', new \DateTime('now'))
            ->orderBy('m.matchDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?MatchAVenir
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
