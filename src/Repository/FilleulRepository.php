<?php

namespace App\Repository;

use App\Entity\Filleul;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Filleul|null find($id, $lockMode = null, $lockVersion = null)
 * @method Filleul|null findOneBy(array $criteria, array $orderBy = null)
 * @method Filleul[]    findAll()
 * @method Filleul[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilleulRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Filleul::class);
    }

    // /**
    //  * @return Filleul[] Returns an array of Filleul objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Filleul
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Filleul[] Returns an array of Filleul objects
     */

    public function findCountriesOfGodsons()
    {
        return $this->createQueryBuilder('f')
            ->select('f.pays')
            ->orderBy('f.pays', 'ASC')
            ->distinct()
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $age
     * @param $sexe
     * @param $pays
     * @return QueryBuilder Returns an array of Filleul objects
     */

    public function findRandomGodsons($age, $sexe, $pays)
    {

        $requete = $this->createQueryBuilder('f');

        if($pays!=null && $pays!= "null") {
            $requete->andWhere('f.pays = :val')
                ->setParameter('val', $pays);
        }
        if($sexe!=null && $sexe!= "null") {
            $requete->andWhere('f.genre = :val')
                ->setParameter('val', $sexe);
        }
        if($age!=null && $age!= "null") {
            switch($age) {
                case "baby" : $requete->andWhere('f.age < 8');
                break;

                case "young" :  $requete->andWhere('f.age <= 12')
                                        ->andWhere('f.age >= 8');
                break;

                case "teen" : $requete->andWhere('f.age > 12');
                break;

                default : break;

            }
        }

        return  $requete->getQuery()
                        ->getResult();

    }


}
