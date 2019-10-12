<?php

namespace App\Repository;

use App\Entity\Sanction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Sanction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sanction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sanction[]    findAll()
 * @method Sanction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SanctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sanction::class);
    }


    public function findByDesc()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByUser ($userId)
    {
        return $this->createQueryBuilder('s')
            ->where('s.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult()
        ;
    }

}
