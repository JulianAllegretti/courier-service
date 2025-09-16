<?php

namespace App\DocumentManagement\Infrastructure\Repository;

use App\DocumentManagement\Domain\Entity\Filed;
use App\DocumentManagement\Domain\Entity\Identification;
use App\DocumentManagement\Domain\Repository\FiledRepository;
use App\DocumentManagement\Domain\ResponsePaginator;
use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;
use App\Shared\Domain\Exceptions\ExistException;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class FiledMysqlRepository extends ServiceEntityRepository implements FiledRepository
{
    const PAGE_LIMIT = 10;

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
    function getDocuments(string $time_start, string $time_end, string $difference_days): array
    {
        $date = new DateTime();
        $queryDateStart = $date->format('Y-m-d') . ' ' . $time_start;
        if ($difference_days > 0) {
            $date->modify('-' . $difference_days . ' days');
            $queryDateStart = $date->format('Y-m-d') . ' ' . $time_start;
        }

        $dateEnd = new DateTime();
        $queryDateEnd = $dateEnd->format('Y-m-d') . ' ' . $time_end;

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

    function getFiled(FiledNumberValueObject $filedNumberValueObject): Filed|null
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('r')
            ->from('App\DocumentManagement\Domain\Entity\Filed', 'r')
            ->where('r.num_radicado = :filedNumber')
            ->setParameter('filedNumber', $filedNumberValueObject->getValue())
            ->getQuery()
            ->getOneOrNullResult();
    }

    function getAllFiled($page, $paramsToSearch): ResponsePaginator
    {
        $queryFiltered = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('r')
            ->from('App\DocumentManagement\Domain\Entity\Filed', 'r')
            ->setFirstResult(($page - 1) * self::PAGE_LIMIT)
            ->setMaxResults(self::PAGE_LIMIT)
            ->orderBy('r.id_radicado', 'DESC');

        if (isset($paramsToSearch['num_radicado']) && $paramsToSearch['num_radicado'] != '') {
            // Usar Full-Text Search en BOOLEAN MODE para simular LIKE '%texto%'
            $searchTerm = '*' . $paramsToSearch['num_radicado'] . '*';
            $queryFiltered = $queryFiltered
                ->andWhere('MATCH(r.num_radicado) AGAINST(:num_radicado IN BOOLEAN MODE)')
                ->setParameter('num_radicado', $searchTerm);
        }

        if (isset($paramsToSearch['name']) && $paramsToSearch['name'] != '') {
            // Usar Full-Text Search en BOOLEAN MODE para simular LIKE '%texto%'
            $searchTerm = '*' . $paramsToSearch['name'] . '*';
            $queryFiltered = $queryFiltered
                ->andWhere('MATCH(r.nombre_completo) AGAINST(:name IN BOOLEAN MODE)')
                ->setParameter('name', $searchTerm);
        }

        if (isset($paramsToSearch['phone']) && $paramsToSearch['phone'] != '') {
            // Usar Full-Text Search en BOOLEAN MODE para simular LIKE '%texto%'
            $searchTerm = '*' . $paramsToSearch['phone'] . '*';
            $queryFiltered = $queryFiltered
                ->andWhere('MATCH(r.telefono) AGAINST(:phone IN BOOLEAN MODE)')
                ->setParameter('phone', $searchTerm);
        }

        if (isset($paramsToSearch['radicado_padre']) && $paramsToSearch['radicado_padre'] != '') {
            // Usar Full-Text Search en BOOLEAN MODE para simular LIKE '%texto%'
            $searchTerm = '*' . $paramsToSearch['radicado_padre'] . '*';
            $queryFiltered = $queryFiltered
                ->andWhere('MATCH(r.radicado_caso_padre) AGAINST(:radicado_padre IN BOOLEAN MODE)')
                ->setParameter('radicado_padre', $searchTerm);
        }

        if (isset($paramsToSearch['guia']) && $paramsToSearch['guia'] != '') {
            // Usar Full-Text Search en BOOLEAN MODE para simular LIKE '%texto%'
            $searchTerm = '*' . $paramsToSearch['guia'] . '*';
            $queryFiltered = $queryFiltered
                ->andWhere('MATCH(r.codigo_guia) AGAINST(:guia IN BOOLEAN MODE)')
                ->setParameter('guia', $searchTerm);
        }

        if (isset($paramsToSearch['created_at']) && $paramsToSearch['created_at'] != '') {
            // Para fechas usar comparación directa en lugar de LIKE
            $queryFiltered = $queryFiltered
                ->andWhere('DATE(r.created_at) = :created_at')
                ->setParameter('created_at', $paramsToSearch['created_at']);
        }

        $queryFiltered = $queryFiltered->getQuery();

        $paginator = new Paginator($queryFiltered);

        $totalItems = $paginator->count();
        $totalPages = ceil($totalItems / self::PAGE_LIMIT);

        return new ResponsePaginator($paginator, $totalPages);
    }

    function getFiledById(int $id_filed): Filed|null
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('f', 'i')
            ->from('App\DocumentManagement\Domain\Entity\Filed', 'f')
            ->where('f.id_radicado = :id')
            ->setParameter('id', $id_filed)
            ->leftJoin('f.identification', 'i')
            ->getQuery()
            ->getOneOrNullResult();
    }

    function getReportByHourAndDate(): array
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select([
                "DATE_FORMAT(r.created_at, '%W') AS diaSemana",
                "HOUR(r.created_at) AS hora",
                "COUNT(r.id_radicado) AS totalRadicados"
            ])
            ->from('App\DocumentManagement\Domain\Entity\Filed', 'r')
            ->where('r.created_at is not null')
            ->groupBy('diaSemana, hora')
            ->addOrderBy('hora', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    function getReport(\DateTime $dateStart, \DateTime|null $dateEnd): array
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->from('App\DocumentManagement\Domain\Entity\Filed', 'r');

        if ($dateEnd == null) {
            $date = $dateStart->format('Y-m-d');
            $query = $query->select([
                "HOUR(r.created_at) AS hora",
                "COUNT(r.id_radicado) AS total"
            ])
            ->where("r.created_at >= '".$date." 00:00:00' and r.created_at <= '".$date." 23:59:59'")
            ->groupBy('hora')
            ->addOrderBy('hora', 'ASC');
        }
        else {
            $initDate = $dateStart->format('Y-m-d');
            $endDate = $dateEnd->format('Y-m-d');
            $query = $query->select([
                "DATE(r.created_at) AS fecha",
                "COUNT(r.id_radicado) AS total"
            ])
                ->where("r.created_at >= '".$initDate." 00:00:00' and r.created_at <= '".$endDate." 23:59:59'")
                ->groupBy('fecha')
                ->addOrderBy('fecha', 'ASC');
        }

        return $query
            ->getQuery()
            ->getArrayResult();
    }
}