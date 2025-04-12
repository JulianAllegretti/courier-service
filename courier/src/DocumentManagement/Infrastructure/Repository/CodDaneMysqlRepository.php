<?php

namespace App\DocumentManagement\Infrastructure\Repository;

use App\DocumentManagement\Domain\Entity\CodDane;
use App\DocumentManagement\Domain\Repository\CodDaneRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CodDaneMysqlRepository extends ServiceEntityRepository implements CodDaneRepository
{

    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, CodDane::class);
    }

    function getCodDane(string $code): CodDane|null
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('c')
            ->from('App\DocumentManagement\Domain\Entity\CodDane', 'c')
            ->where('c.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult();
    }
}