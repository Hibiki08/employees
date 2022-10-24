<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    static public function createUser(
        string $name,
        int $uniqueKey,
        int $parentKey = null
    ): User
    {
        $user = new User();
        $user->setName($name);
        $user->setUniqueKey($uniqueKey);
        $user->setParentKey($parentKey);
        return $user;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return parent::getEntityManager();
    }
}
