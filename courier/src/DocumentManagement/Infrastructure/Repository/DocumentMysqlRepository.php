<?php

namespace App\DocumentManagement\Infrastructure\Repository;

use App\DocumentManagement\Domain\Entity\Document;
use App\DocumentManagement\Domain\Repository\DocumentRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DocumentMysqlRepository extends ServiceEntityRepository implements DocumentRepository
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }


    function create(Document $document): Document
    {
        $this->registry->getManager()->persist($document);
        $this->registry->getManager()->flush();

        return $document;
    }
}