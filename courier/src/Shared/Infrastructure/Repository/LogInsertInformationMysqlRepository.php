<?php

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Repository\LogInsertInformationRepository;
use DateTime;
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


    function getAllLogs(): array
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('App\Shared\Domain\Entity\LogInsertInformation', 'l')
            ->setMaxResults(20)
            ->getQuery()
            ->getArrayResult();
    }
}