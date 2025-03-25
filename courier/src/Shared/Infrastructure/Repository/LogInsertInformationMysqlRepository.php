<?php

namespace App\Shared\Infrastructure\Repository;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Log;
use App\Shared\Domain\Repository\LogInsertInformationRepository;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use App\Shared\Domain\Entity\LogInsertInformation;

class LogInsertInformationMysqlRepository extends ServiceEntityRepository implements LogInsertInformationRepository
{
    const PAGE_LIMIT = 10;

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
            ->from('App\Shared\Domain\Entity\LogInsertInformation', 'l')
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
            ->from('App\Shared\Domain\Entity\LogInsertInformation', 'l')
            ->setFirstResult(($page - 1) * self::PAGE_LIMIT)
            ->setMaxResults(self::PAGE_LIMIT);

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
            ->from('App\Shared\Domain\Entity\LogInsertInformation', 'l')
            ->where('l.numero_radicado = :num_filed')
            ->setParameter('num_filed', $num_filed)
            ->getQuery()
            ->getArrayResult();
    }

    function getLogById(int $log_id): Log|null
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('App\Shared\Domain\Entity\LogInsertInformation', 'l')
            ->where('l.id_log_insert_information = :id')
            ->setParameter('id', $log_id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    function getReport(\DateTime $dateStart, ?\DateTime $dateEnd): array
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->from('App\Shared\Domain\Entity\LogInsertInformation', 'l');

        if ($dateEnd == null) {
            $date = $dateStart->format('Y-m-d');
            $query = $query->select([
                "HOUR(l.created_at) AS hora",
                "COUNT(l.id_log_insert_information) AS total"
            ])
                ->where("l.created_at >= '".$date." 00:00:00' and l.created_at <= '".$date." 23:59:59'")
                ->groupBy('hora')
                ->addOrderBy('hora', 'ASC');
        }
        else {
            $initDate = $dateStart->format('Y-m-d');
            $endDate = $dateEnd->format('Y-m-d');
            $query = $query->select([
                "DATE(l.created_at) AS fecha",
                "COUNT(l.id_log_insert_information) AS total"
            ])
                ->where("l.created_at >= '".$initDate." 00:00:00' and l.created_at <= '".$endDate." 23:59:59'")
                ->groupBy('fecha')
                ->addOrderBy('fecha', 'ASC');
        }

        return $query
            ->getQuery()
            ->getArrayResult();
    }

    function getReportPie(\DateTime $dateStart, ?\DateTime $dateEnd): array
    {
        $initDate = $dateStart->format('Y-m-d');
        $endDate = $dateStart->format('Y-m-d');
        if ($dateEnd != null) {
            $endDate = $dateEnd->format('Y-m-d');
        }

        return  $this->getEntityManager()
            ->createQueryBuilder()
            ->from('App\Shared\Domain\Entity\LogInsertInformation', 'l')
            ->select([
                "JSON_EXTRACT(l.error, '$.ErrorCode') AS errorCode",
                "COUNT(l.id_log_insert_information) AS total"
            ])
            ->groupBy('errorCode')
            ->addOrderBy('errorCode', 'ASC')
            ->where("l.created_at >= '".$initDate." 00:00:00' and l.created_at <= '".$endDate." 23:59:59'")
            ->getQuery()
            ->getArrayResult();
    }
}