<?php

namespace App\Repository;

use App\Entity\Adversaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Adversaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adversaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adversaires[]    findAll()
 * @method Adversaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdversairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adversaires::class);
    }

    public function findajaxAdversaire($value)
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->andWhere('a.nom LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Adversaires[] Returns an array of Adversaires objects
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
    public function findOneBySomeField($value): ?Adversaires
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
