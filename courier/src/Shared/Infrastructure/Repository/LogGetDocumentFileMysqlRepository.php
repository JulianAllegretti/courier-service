<?php

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Entity\LogGetDocumentFile;
use App\Shared\Domain\Repository\LogGetDocumentFileRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LogGetDocumentFileMysqlRepository extends ServiceEntityRepository implements LogGetDocumentFileRepository
{

    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, LogGetDocumentFile::class);
    }

    function create(LogGetDocumentFile $log): LogGetDocumentFile
    {
        $this->registry->getManager()->persist($log);
        $this->registry->getManager()->flush();

        return $log;
    }
}