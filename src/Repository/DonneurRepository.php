<?php

namespace App\Repository;

use App\Entity\Donneur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Donneur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donneur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donneur[]    findAll()
 * @method Donneur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonneurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Donneur::class);
    }
    public function requestMail($email) {
        
        $em=$this->getEntityManager();

        $query = $em->createQuery
            (
            'SELECT d 
            FROM App\Entity\Donneur d
            WHERE d.email = :mail'
            )
           ->setParameter('mail', $email);
            

      return $query->getResult();
      
    }
    // /**
    //  * @return Donneur[] Returns an array of Donneur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Donneur
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
