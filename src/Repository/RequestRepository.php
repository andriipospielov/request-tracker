<?php

namespace App\Repository;

use App\Entity\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Request::class);
    }

    public function findAllAsArray(array $criteria): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb->select('r')
            ->from('App:Request', 'r')
            ->getQuery();

        return $query->getArrayResult();
    }
}
