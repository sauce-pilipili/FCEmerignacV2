<?php

namespace App\Repository;

use App\Entity\SubGalery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubGalery|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubGalery|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubGalery[]    findAll()
 * @method SubGalery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubGaleryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubGalery::class);
    }


    public function findAllSubGalery()
    {
        return $this->createQueryBuilder('s')
            ->select('s','g')
            ->join('s.Galery','g')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function ShowSubGalery($id): ?SubGalery
    {
        return $this->createQueryBuilder('s')
            ->select( 's','a')
            ->leftJoin('s.albums','a')
            ->where('s.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return SubGalery[] Returns an array of SubGalery objects
    //  */

    public function findSousGalerieParCategory($value)
    {
        return $this->createQueryBuilder('s')
            ->select('s','g')
            ->join('s.galery','g')
            ->andWhere('g.name = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findMainSousGalerieParCategory($value)
    {
        return $this->createQueryBuilder('s')
            ->select('s','g')
            ->join('s.galery','g')
            ->andWhere('g.id = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAPhoto($value)
    {
        return $this->createQueryBuilder('s')
            ->select('images.name')
            ->join('s.albums','albums')
            ->join('albums.images','images')
            ->andWhere('s.id = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }






    // /**
    //  * @return SubGalery[] Returns an array of SubGalery objects
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
    public function findOneBySomeField($value): ?SubGalery
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
