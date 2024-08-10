<?php

namespace App\DocumentManagement\Infrastructure\Repository;

use App\DocumentManagement\Domain\Entity\Identification;
use App\DocumentManagement\Domain\Repository\IdentificationRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class IdentificationMysqlRepository extends ServiceEntityRepository implements IdentificationRepository
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Identification::class);
    }

    /**
     */
    function createIfNoExist(Identification $identification): Identification
    {
        $exist = $this->findBy([
            'numero_documento' => $identification->getNumeroDocumento(), 'tipo_documento' => $identification->getTipoDocumento()
        ]);

        if (count($exist) > 0) {
            return $exist[0];
        }

        $this->registry->getManager()->persist($identification);
        $this->registry->getManager()->flush();

        return $identification;
    }
}