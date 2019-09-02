<?php

namespace App\Repository;

use App\Entity\AmountDonate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AmountDonate|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmountDonate|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmountDonate[]    findAll()
 * @method AmountDonate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmountDonateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmountDonate::class);
    }

    // /**
    //  * @return AmountDonate[] Returns an array of AmountDonate objects
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
    public function findOneBySomeField($value): ?AmountDonate
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
