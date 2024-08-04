<?php

namespace App\DocumentManagement\Infrastructure\Repository;

use App\DocumentManagement\Domain\Entity\Filed;
use App\DocumentManagement\Domain\Repository\FiledRepository;
use App\Shared\Domain\Exceptions\ExistException;
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
    function create(Filed $filed): Filed
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

        $this->registry->getManager()->persist($filed);
        $this->registry->getManager()->flush();

        return $filed;
    }
}