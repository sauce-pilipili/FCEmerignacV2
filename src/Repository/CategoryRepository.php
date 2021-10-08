<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
    public function findAllCategory()
    {
        return $this->createQueryBuilder('c')
            ->Where('c.name NOT LIKE :val')
            ->setParameter('val', 'Info-Club')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    public function findTeamInCategory($value){
        return $this->createQueryBuilder('c')
            ->select('c','e')
            ->leftJoin('c.equipes','e')
            ->andWhere('c.name = :val')
            ->setParameter('val', $value)
            ->getQuery()->getResult();

    }


    public function findAllCategoryWithArticles()
    {
        return $this->createQueryBuilder('c')
            ->Where('c.name NOT LIKE :val')
            ->setParameter('val', 'Info-Club')
            ->join('c.equipes','e')
            ->join('e.articles','a')
            ->andWhere('a is not null')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
