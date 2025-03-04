<?php

namespace App\Shared\Infrastructure\Repository;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Repository\LogInsertInformationRepository;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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


    function getAllLogs(int $page): ResponsePaginator
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('App\Shared\Domain\Entity\LogInsertInformation', 'l')
            ->setFirstResult(($page - 1) * self::PAGE_LIMIT)
            ->setMaxResults(self::PAGE_LIMIT)
            ->getQuery();

        $paginator = new Paginator($query);

        $totalItems = $paginator->count();
        $totalPages = ceil($totalItems/self::PAGE_LIMIT);

        return new ResponsePaginator($paginator, $totalPages);
    }
}