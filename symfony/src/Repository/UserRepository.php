<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getAllUsersByASC()
    {
        $roles = "ROLE_ASSIGNATOR";
        return $this->createQueryBuilder('u')
        ->orderBy('u.username', 'ASC')
        ->getQuery()
        ->getResult()
        ;
    }

    public function getAssignator()
    {
        $roles = "ROLE_ASSIGNATOR";
        return $this->createQueryBuilder('u')
        ->where('u.roles LIKE :roles')
        ->setParameter('roles', '%"'.$roles.'"%')
        ->getQuery()
        ->getResult()
        ;
    }

    public function getModerator()
    {
        $roles = "ROLE_MODERATOR";
        return $this->createQueryBuilder('u')
        ->where('u.roles LIKE :roles')
        ->setParameter('roles', '%"'.$roles.'"%')
        ->getQuery()
        ->getResult()
        ;
    }

    public function getAdmin()
    {
        $roles = "ROLE_ADMIN";
        return $this->createQueryBuilder('u')
        ->where('u.roles LIKE :roles')
        ->setParameter('roles', '%"'.$roles.'"%')
        ->getQuery()
        ->getResult()
        ;
    }

    public function getBorderAdmin()
    {
        return $this->createQueryBuilder('u')
        ->where('u.borderline = 1')
        ->getQuery()
        ->getResult()
        ;
    }

    public function getBorder()
    {
        return $this->createQueryBuilder('u')
        ->where('u.borderline = 1')
        ->join('u.actions', 'action')
        ->getQuery()
        ->getResult()
        ;
    }

    public function findByUsername($username)
    {
        return $this->createQueryBuilder('u')
        ->select('u.id')
        ->where('u.username = :username')
        ->setParameter('username', $username)
        ->getQuery()
        ->getResult()
        ;
    }
}
