<?php

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Repository\LogInsertInformationRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Shared\Domain\Entity\LogInsertInformation;

class LogInsertInformationMysqlRepository extends ServiceEntityRepository implements LogInsertInformationRepository
{

    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, LogInsertInformation::class);
    }

    function create(LogInsertInformation $log): LogInsertInformation
    {
        $this->registry->getManager()->persist($log);
        $this->registry->getManager()->flush();

        return $log;
    }
}