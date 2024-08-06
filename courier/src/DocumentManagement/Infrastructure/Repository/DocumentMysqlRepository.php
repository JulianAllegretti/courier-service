<?php

namespace App\DocumentManagement\Infrastructure\Repository;

use App\DocumentManagement\Domain\Entity\Document;
use App\DocumentManagement\Domain\Repository\DocumentRepository;
use App\Shared\Domain\Exceptions\DocumentNotExistException;
use App\Shared\Domain\Exceptions\ExistException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DocumentMysqlRepository extends ServiceEntityRepository implements DocumentRepository
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }


    /**
     * @throws ExistException
     */
    function create(Document $document): Document
    {
        $exist = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('d')
            ->from('App\DocumentManagement\Domain\Entity\Document', 'd')
            ->where('d.id_gestor_documento = :documentId')
            ->setParameter('documentId', $document->getIdGestorDocumento())
            ->getQuery()
            ->getOneOrNullResult();

        if (isset($exist) && !empty($exist->getRuta())) {
            throw new ExistException('El Documento ya fue creado');
        }

        if (isset($exist) && empty($exist->getRuta())) {
            return $document;
        }

        $this->registry->getManager()->persist($document);
        $this->registry->getManager()->flush();

        return $document;
    }

    /**
     * @throws DocumentNotExistException
     */
    function updatePathFile(string $documentId): void
    {
        $exist = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('d')
            ->from('App\DocumentManagement\Domain\Entity\Document', 'd')
            ->where('d.id_gestor_documento = :documentId')
            ->setParameter('documentId', $documentId)
            ->getQuery()
            ->getOneOrNullResult();

        if (!isset($exist)) {
            throw new DocumentNotExistException('El documento no existe.');
        }

        $exist->setRuta('files/'.$documentId.'.pdf');
        $this->registry->getManager()->persist($exist);
        $this->registry->getManager()->flush();
    }
}