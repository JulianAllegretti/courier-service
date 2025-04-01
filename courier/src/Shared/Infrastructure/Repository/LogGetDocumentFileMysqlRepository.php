<?php

namespace App\Shared\Infrastructure\Repository;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Entity\LogGetDocumentFile;
use App\Shared\Domain\Log;
use App\Shared\Domain\Repository\LogGetDocumentFileRepository;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class LogGetDocumentFileMysqlRepository extends ServiceEntityRepository implements LogGetDocumentFileRepository
{
    const PAGE_LIMIT = 10;

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

    function getLogs(string $time_start, string $time_end, string $difference_days): array
    {
        $date = new DateTime();
        $queryDateStart = $date->format('Y-m-d') . ' '. $time_start;
        if ($difference_days > 0) {
            $date->modify('-'.$difference_days.' days');
            $queryDateStart = $date->format('Y-m-d') . ' '. $time_start;
        }

        $dateEnd = new DateTime();
        $queryDateEnd = $dateEnd->format('Y-m-d') . ' '. $time_end;

        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('App\Shared\Domain\Entity\LogGetDocumentFile', 'l')
            ->where('l.created_at >= :date_start')
            ->andWhere('l.created_at <= :date_end')
            ->setParameter('date_start', $queryDateStart)
            ->setParameter('date_end', $queryDateEnd)
            ->getQuery()
            ->getArrayResult();
    }


    function getAllLogs(int $page, array $paramsToSearch): ResponsePaginator
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('App\Shared\Domain\Entity\LogGetDocumentFile', 'l')
            ->setFirstResult(($page - 1) * self::PAGE_LIMIT)
            ->setMaxResults(self::PAGE_LIMIT)
            ->orderBy('l.id_log_get_document', 'DESC');

        if (isset($paramsToSearch['id_radicado']) && $paramsToSearch['id_radicado'] != ''){
            $query = $query
                ->andWhere('l.numero_radicado like :id_radicado')
                ->setParameter('id_radicado','%'.$paramsToSearch['id_radicado'].'%');
        }

        if (isset($paramsToSearch['error']) && $paramsToSearch['error'] != ''){
            $query = $query
                ->andWhere('l.error like :error')
                ->setParameter('error','%'.$paramsToSearch['error'].'%');
        }

        if (isset($paramsToSearch['created_at']) && $paramsToSearch['created_at'] != ''){
            $query = $query
                ->andWhere('l.created_at like :created_at')
                ->setParameter('created_at','%'.$paramsToSearch['created_at'].'%');
        }

        if (isset($paramsToSearch['id_documento']) && $paramsToSearch['id_documento'] != ''){
            $query = $query
                ->andWhere('l.id_documento like :id_documento')
                ->setParameter('id_documento','%'.$paramsToSearch['id_documento'].'%');
        }

        $query = $query->getQuery();

        $paginator = new Paginator($query);

        $totalItems = $paginator->count();
        $totalPages = ceil($totalItems/self::PAGE_LIMIT);

        return new ResponsePaginator($paginator, $totalPages);
    }

    function getLogsByNumFiled(string $num_filed): array
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('App\Shared\Domain\Entity\LogGetDocumentFile', 'l')
            ->where('l.numero_radicado = :num_filed')
            ->setParameter('num_filed', $num_filed)
            ->getQuery()
            ->getArrayResult();
    }

    function getLogsByDocumentId(string $document_id): array
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('App\Shared\Domain\Entity\LogGetDocumentFile', 'l')
            ->where('l.id_documento = :document_id')
            ->setParameter('document_id', $document_id)
            ->getQuery()
            ->getArrayResult();
    }

    function getLogById(int $log_id): Log|null
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('App\Shared\Domain\Entity\LogGetDocumentFile', 'l')
            ->where('l.id_log_get_document = :id')
            ->setParameter('id', $log_id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}