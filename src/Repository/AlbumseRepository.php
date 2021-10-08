<?php

namespace App\Repository;

use App\Entity\Albumse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Albumse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Albumse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Albumse[]    findAll()
 * @method Albumse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Albumse::class);
    }

    // /**
    //  * @return Albumse[] Returns an array of Albumse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Albumse
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
