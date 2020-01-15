<?php

namespace App\Repository;

use App\Entity\Breaks;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Breaks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Breaks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Breaks[]    findAll()
 * @method Breaks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreaksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Breaks::class);
    }

    public function findTodayBreaksForUser(User $user): ?Breaks
    {
        return $this->createQueryBuilder('b')
            ->where('DAY(b.date_debut) = DAY(NOW())')
            ->andwhere('MONTH(b.date_debut) = MONTH(NOW())')
            ->andwhere('YEAR(b.date_debut) = YEAR(NOW())')
            ->andwhere('b.user = :user')
            ->andwhere('b.date_fin IS NULL')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return Breaks[] Returns an array of Breaks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Breaks
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
