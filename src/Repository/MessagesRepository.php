<?php

namespace App\Repository;

use App\Entity\Messages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Messages>
 */
class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messages::class);
    }

    //    /**
    //     * @return Messages[] Returns an array of Messages objects
    //     */
    //compter les messages non archivés
    public function countMessageNotArchived(): int
        {
            $qb = $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->where('m.isArchived = :isArchived')
            ->setParameter('isArchived', false); // Assuming isArchived is a boolean

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
//récuperer les messages archivés
    public function MessageArchived(): array
{
    $qb = $this->createQueryBuilder('m')
        ->select('m')
        ->where('m.isArchived = :isArchived')
        ->setParameter('isArchived', true);

    return $qb->getQuery()->getResult();
}
//récuperer les messages non archivés
public function MessageNotArchived(): array
{
    $qb = $this->createQueryBuilder('m')
        ->select('m')
        ->where('m.isArchived = :isArchived')
        ->setParameter('isArchived',false);

    return $qb->getQuery()->getResult();
}
    //    public function findOneBySomeField($value): ?Messages
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
