<?php

namespace App\Repository;

use App\Entity\Annonces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annonces>
 */
class AnnoncesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonces::class);
    }
    public function getMinMaxValues()
    {
        $qb = $this->createQueryBuilder('a')
            ->select('MIN(a.prix) AS min_prix, MAX(a.prix) AS max_prix, 
                    MIN(a.annee) AS min_annee, MAX(a.annee) AS max_annee,
                    MIN(a.km) AS min_km, MAX(a.km) AS max_km');

        return $qb->getQuery()->getSingleResult();
    }

    //    /**
    //     * @return Annonces[] Returns an array of Annonces objects
    //     */
   // public function findByExampleField($value): array
    //{
     //   return $this->createQueryBuilder('a')
      //      ->andWhere('a.exampleField = :val')
     //       ->setParameter('val', $value)
     //       //->orderBy('a.id', 'ASC')
            //->setMaxResults(10)
      //      ->getQuery()
      //      ->getResult()
    //    ;
   // }

    //    public function findOneBySomeField($value): ?Annonces
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
