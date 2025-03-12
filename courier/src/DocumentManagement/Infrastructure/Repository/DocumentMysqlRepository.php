<?php

namespace App\DocumentManagement\Infrastructure\Repository;

use App\DocumentManagement\Domain\Entity\Document;
use App\DocumentManagement\Domain\Entity\Filed;
use App\DocumentManagement\Domain\Repository\DocumentRepository;
use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Exceptions\DocumentNotExistException;
use App\Shared\Domain\Exceptions\ExistException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class DocumentMysqlRepository extends ServiceEntityRepository implements DocumentRepository
{
    const PAGE_LIMIT = 10;

    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }


    /**
     * @throws ExistException
     */
    function create(Document $document, Filed $filed): Document
    {
        $document->setFiled($filed);
        $this->registry->getManager()->persist($document);
        $this->registry->getManager()->flush();

        return $document;
    }

    /**
     * @throws DocumentNotExistException
     */
    function updatePathFile(string $documentId, string $guideNumber): void
    {
        $filed = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('f')
            ->from('App\DocumentManagement\Domain\Entity\Filed', 'f')
            ->where('f.codigo_guia = :guideNumber')
            ->setParameter('guideNumber', $guideNumber)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (!isset($filed)) {
            throw new DocumentNotExistException('El radicado de este documento no existe.');
        }

        $exist = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('d')
            ->from('App\DocumentManagement\Domain\Entity\Document', 'd')
            ->where('d.id_gestor_documento = :documentId')
            ->andWhere('d.fk_radicado = :filedId')
            ->setParameter('documentId', $documentId)
            ->setParameter('filedId', $filed->getIdRadicado())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (!isset($exist)) {
            throw new DocumentNotExistException('El documento no existe.');
        }

        $exist->setRuta('files/'.$documentId.'.pdf');
        $this->registry->getManager()->persist($exist);
        $this->registry->getManager()->flush();
    }

    public function getAllDocuments(int $page, array $paramsToSearch): ResponsePaginator
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('d')
            ->from('App\DocumentManagement\Domain\Entity\Document', 'd')
            ->setFirstResult(($page - 1) * self::PAGE_LIMIT)
            ->setMaxResults(self::PAGE_LIMIT);

        if (isset($paramsToSearch['id_documento']) && $paramsToSearch['id_documento'] != ''){
            $query = $query
                ->andWhere('d.id_gestor_documento like :id_documento')
                ->setParameter('id_documento','%'.$paramsToSearch['id_documento'].'%');
        }

        if (isset($paramsToSearch['ruta']) && $paramsToSearch['ruta'] != ''){
            $query = $query
                ->andWhere('d.ruta like :ruta')
                ->setParameter('ruta','%'.$paramsToSearch['ruta'].'%');
        }

        if (isset($paramsToSearch['created_at']) && $paramsToSearch['created_at'] != ''){
            $query = $query
                ->andWhere('d.created_at like :created_at')
                ->setParameter('created_at','%'.$paramsToSearch['created_at'].'%');
        }

        $query = $query->getQuery();

        $paginator = new Paginator($query);

        $totalItems = $paginator->count();
        $totalPages = ceil($totalItems/self::PAGE_LIMIT);

        return new ResponsePaginator($paginator, $totalPages);
    }
}