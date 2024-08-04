<?php

namespace App\DocumentManagement\Infrastructure\Repository;

use App\DocumentManagement\Application\Helpers\GuideNumberHelper;
use App\DocumentManagement\Domain\Entity\GuideNumber;
use App\DocumentManagement\Domain\Repository\GuideNumberRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

class GuideNumberMysqlRepository extends ServiceEntityRepository implements GuideNumberRepository
{
    private const ID_GUIDE_NUMBER = 1;
    private GuideNumberHelper $helper;

    public function __construct(private ManagerRegistry $registry)
    {
        $this->helper = new GuideNumberHelper();
        parent::__construct($registry, GuideNumber::class);
    }

    /**
     * @return string
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws \Exception
     */

    function updateCurrentNumber(): string
    {
        $entity = $this->getEntityManager()->find('App\DocumentManagement\Domain\Entity\GuideNumber', self::ID_GUIDE_NUMBER);
        $this->getEntityManager()->lock($entity, LockMode::PESSIMISTIC_WRITE);
        $guidNumber = !empty($entity->getCurrentNumber()) ?
            $this->nextNumber($entity->getCurrentNumber()) :
            $entity->getInitialNumber();
        $entity->setCurrentNumber($guidNumber);
        $this->getEntityManager()->flush();

        return $guidNumber;
    }

    /**
     * @throws \Exception
     */
    private function nextNumber(string $currentNumber): string
    {
        $nextNumber = $this->helper->extractNumbersFromGuide($currentNumber) + 1;
        if ($nextNumber == -1) {
            throw new \Exception('No se pudo generar el numero de guia; numero actual: ' . $currentNumber);
        }

        $letters = $this->helper->extractLettersFromGuide($currentNumber);
        if ($letters== '-1') {
            throw new \Exception('No se pudo generar el numero de guia; numero actual: ' . $currentNumber);
        }

        return $this->helper->completeNumberOfGuide($letters, $nextNumber);
    }

    /**
     * @throws \Exception
     */
    function getGuideNumber(): GuideNumber
    {
        $guide = $this->findOneBy([]);
        if (is_null($guide)) {
            throw new \Exception('La configuracion de guia no existe');
        }

        return $guide;
    }
}