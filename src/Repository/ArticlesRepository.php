<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }
    public function findimage($value)
    {
        return $this->createQueryBuilder('a')
            ->select('a','i')
            ->join('a.photoFond','i')
            ->andWhere('a.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findLast(): ?Articles
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdDate','DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
            ;
    }
    public function findByCategory($value): ?Articles
    {

        return $this->createQueryBuilder('a')
            ->join('a.equipe','e')
            ->join('e.category' , 'c')
            ->Where('c.name like :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('a.createdDate','DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getSingleResult()
            ;
    }
    public function findByCategoryInfoClub($value)
    {

        return $this->createQueryBuilder('a')
            ->join('a.equipe','e')
            ->join('e.category','c')
            ->Where('c.name like :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('a.createdDate','DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findLastByCategory($value): ?Articles
    {

        return $this->createQueryBuilder('a')
            ->join('a.categorie','c')
            ->leftjoin('a.photoEnAvant','p')
            ->leftjoin('a.photoFond','f')
            ->select('a','c','p','f')
            ->Where('c.name like :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('a.createdDate','DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getSingleResult()
            ;
    }
    // /**
    //  * @return Articles[] Returns an array of Articles objects
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
    public function findOneBySomeField($value): ?Articles
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
