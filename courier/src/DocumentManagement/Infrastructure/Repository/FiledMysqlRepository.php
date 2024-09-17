<?php

namespace App\DocumentManagement\Infrastructure\Repository;

use App\DocumentManagement\Domain\Entity\Filed;
use App\DocumentManagement\Domain\Entity\Identification;
use App\DocumentManagement\Domain\Repository\FiledRepository;
use App\Shared\Domain\Exceptions\ExistException;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FiledMysqlRepository extends ServiceEntityRepository implements FiledRepository
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Filed::class);
    }


    /**
     * @throws ExistException
     */
    function create(Filed $filed, Identification $identification): Filed
    {
        $exist = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('r')
            ->from('App\DocumentManagement\Domain\Entity\Filed', 'r')
            ->where('r.num_radicado = :filedNumber')
            ->orWhere('r.codigo_guia = :guideNumber')
            ->setParameter('filedNumber', $filed->getNumRadicado())
            ->setParameter('guideNumber', $filed->getCodigoGuia())
            ->getQuery()
            ->getOneOrNullResult();

        if (isset($exist)) {
            throw new ExistException('El numero de radicado o el codigo de guia ya existen');
        }

        $filed->setIdentification($identification);
        $this->registry->getManager()->persist($filed);
        $this->registry->getManager()->flush();

        return $filed;
    }

    /**
     * @param string $time_start
     * @param string $time_end
     * @param string $difference_days
     * @return Filed[]
     */
    function getDocuments(string $time_start, string $time_end, string $difference_days) : array {
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
            ->select('f', 'i', 'd')
            ->from('App\DocumentManagement\Domain\Entity\Filed', 'f')
            ->where('f.created_at >= :date_start')
            ->andWhere('f.created_at <= :date_end')
            ->setParameter('date_start', $queryDateStart)
            ->setParameter('date_end', $queryDateEnd)
            ->leftJoin('f.identification', 'i')
            ->leftJoin('f.documents', 'd')
            ->getQuery()
            ->getArrayResult();
    }
}