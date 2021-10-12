<?php

namespace App\Repository;

use App\Entity\Albums;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Albums|null find($id, $lockMode = null, $lockVersion = null)
 * @method Albums|null findOneBy(array $criteria, array $orderBy = null)
 * @method Albums[]    findAll()
 * @method Albums[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Albums::class);
    }


    public function findAlbums($value): ?Albums
    {
        return $this->createQueryBuilder('a')
            ->select('a','i')
            ->leftJoin('a.images','i')
            ->andWhere('a.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    public function findMainAlbumParSousCategory($value)
    {
        return $this->createQueryBuilder('a')
            ->select('a','s')
            ->join('a.subGalery','s')
            ->andWhere('a.subGalery = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAPhoto($value)
    {
        return $this->createQueryBuilder('a')
            ->select('images.name')
            ->join('a.images','images')
            ->andWhere('a.id = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    // /**
    //  * @return Albums[] Returns an array of Albums objects
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
    public function findOneBySomeField($value): ?Albums
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
