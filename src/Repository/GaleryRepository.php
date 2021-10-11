<?php

namespace App\Repository;

use App\Entity\Galery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Galery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Galery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Galery[]    findAll()
 * @method Galery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GaleryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Galery::class);
    }

    // /**
    //  * @return Galery[] Returns an array of Galery objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findAPhoto($value)
    {
        return $this->createQueryBuilder('g')
            ->select('images.name')
            ->join('g.subGaleries', 'sub')
            ->join('sub.albums','albums')
            ->join('albums.images','images')
            ->andWhere('g.id = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
