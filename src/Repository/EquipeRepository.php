<?php

namespace App\Repository;

use App\Entity\Equipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Equipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipe[]    findAll()
 * @method Equipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipe::class);
    }

    // /**
    //  * @return Equipe[] Returns an array of Equipe objects
    //  */

    public function findAllTeam($value = null)
    {
        $qb = $this->createQueryBuilder('e')
            ->join('e.category', 'c')
            ->Where('c.name NOT LIKE  :val')
            ->setParameter('val', '%Info-Club%');
        if ($value != null) {

            $qb->andWhere('e.category = :value')
            ->setParameter('value', '%'.$value.'%');

            };
        $qb->orderBy('e.id', 'ASC');
        return $qb->getQuery()
            ->getResult();
    }


    public function findEquipe($id): ?Equipe
    {
        return $this->createQueryBuilder('e')
            ->leftjoin('e.joueurs', 'j')
            ->leftjoin('j.photoPortrait', 'photoPortrait')
            ->andWhere('e.name LIKE :val')
            ->setParameter('val', '%' . $id . '%')
            ->getQuery()
            ->getOneOrNullResult();
    }

}
