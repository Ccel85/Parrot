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
     //RECUPERER VALEUR MIN MAX DE RANGE
function minMaxRange(){
    // Exemple de requête pour obtenir les valeurs minimales et maximales
        $qb = $this->createQueryBuilder('c')
            ->select('MIN(c.prix) AS min_prix,
            MAX(c.prix) AS max_prix,
            MIN(c.annee) AS min_annee,
            MAX(c.annee) AS max_annee,
            MIN(c.km) AS min_km,
            MAX(c.km) AS max_km');

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
