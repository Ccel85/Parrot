<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comments>
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

//    /**
//     * @return Comments[] Returns an array of Comments objects
//     */
public function lastBestComments(): array
{
    $value = 4;
    $qb = $this -> createQueryBuilder('c')
            ->andWhere('c.rating >= :val')
            ->setParameter('val', $value)
            ->orderBy('c.isCreatedAt', 'DESC')
            ->setMaxResults(10);
        
        return $qb->getQuery()
                ->getResult()
        ;
    }

    public function countCommentsNotArchived(): int
        {
            $qb = $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->where('c.isArchived = :isArchived')
            ->setParameter('isArchived', false);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }


//    public function findOneBySomeField($value): ?Comments
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
