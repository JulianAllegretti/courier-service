<?php

namespace App\DocumentManagement\Application\Creators;

use App\DocumentManagement\Domain\Entity\Document;
use App\DocumentManagement\Domain\Entity\Filed;
use App\DocumentManagement\Domain\Entity\Identification as IdentificationEntity;
use App\DocumentManagement\Domain\Enums\PortPayment;
use App\DocumentManagement\Domain\Enums\Printed;
use App\DocumentManagement\Domain\Enums\Priority;
use App\DocumentManagement\Domain\Enums\ProcessType;
use App\DocumentManagement\Domain\Enums\TypePortPayment;
use App\DocumentManagement\Domain\Repository\DocumentRepository;
use App\DocumentManagement\Domain\Repository\FiledRepository;
use App\DocumentManagement\Domain\Repository\GuideNumberRepository;
use App\DocumentManagement\Domain\Repository\IdentificationRepository;
use App\DocumentManagement\Domain\ValueObjects\AddressValueObject;
use App\DocumentManagement\Domain\ValueObjects\ApplicantValueObject;
use App\DocumentManagement\Domain\ValueObjects\CellphoneValueObject;
use App\DocumentManagement\Domain\ValueObjects\CodDaneValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\DocumentValueObject;
use App\DocumentManagement\Domain\ValueObjects\FiledCaseFatherValueObject;
use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\FullNameValueObject;
use App\DocumentManagement\Domain\ValueObjects\GuideNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\Identification\IdentificationValueObject;
use App\DocumentManagement\Domain\ValueObjects\PhoneValueObject;
use App\DocumentManagement\Domain\ValueObjects\PrintedGuideValueObject;
use App\DocumentManagement\Domain\ValueObjects\ProcessNumberValueObject;
use App\Shared\Domain\Exceptions\MaxLengthException;
use App\Shared\Domain\Exceptions\NullException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

readonly class FiledCreator
{
    public function __construct(
        private IdentificationRepository $repository,
        private FiledRepository          $filedRepository,
        private DocumentRepository       $documentRepository,
        private GuideNumberRepository    $guideNumberRepository,
        private EntityManagerInterface   $entityManager,
        private ManagerRegistry          $managerRegistry
    )
    {
    }

    /**
     * @param FiledNumberValueObject $filedNumber
     * @param CodDaneValueObject $codDane
     * @param AddressValueObject $address
     * @param PrintedGuideValueObject $printedGuide
     * @param DocumentValueObject[] $documents
     * @param FullNameValueObject $fullName
     * @param Priority $priority
     * @param Printed $printed
     * @param TypePortPayment $typePortPayment
     * @param ProcessType $processType
     * @param PortPayment $portPayment
     * @param PhoneValueObject|null $phone
     * @param FiledCaseFatherValueObject|null $filedCaseFather
     * @param IdentificationValueObject|null $identification
     * @param CellphoneValueObject|null $cellphone
     * @param ApplicantValueObject|null $applicant
     * @param ProcessNumberValueObject|null $processNumber
     * @return string
     * @throws MaxLengthException
     * @throws NullException
     */
    public function __invoke(
        FiledNumberValueObject      $filedNumber,
        CodDaneValueObject          $codDane,
        AddressValueObject          $address,
        PrintedGuideValueObject     $printedGuide,
        array                       $documents,
        FullNameValueObject         $fullName,
        Priority                    $priority,
        Printed                     $printed,
        TypePortPayment             $typePortPayment,
        ProcessType                 $processType,
        PortPayment                 $portPayment,
        ?PhoneValueObject           $phone,
        ?FiledCaseFatherValueObject $filedCaseFather,
        ?IdentificationValueObject  $identification,
        ?CellphoneValueObject       $cellphone,
        ?ApplicantValueObject       $applicant,
        ?ProcessNumberValueObject   $processNumber
    ): string
    {
        $this->entityManager->beginTransaction();

        try {
            $identificationDb = null;
            if ($identification) {
                $identificationDb = new IdentificationEntity(
                    null, $identification->getDocument()->getValue(), $identification->getDocumentType()->value
                );
                $identificationDb = $this->repository->createIfNoExist($identificationDb);
            }

            $guideNumber = new GuideNumberValueObject($this->guideNumberRepository->updateCurrentNumber());

            $filed = new Filed(
                null, $identificationDb?->getIdIdentificacion(), $filedNumber->getValue(),
                $cellphone->getValue(), $processNumber->getValue(), $codDane->getValue(), $address->getValue(), $printedGuide->getValue(),
                $fullName->getValue(), $phone->getValue(), $priority->value, $printed->value, $portPayment->value,
                $typePortPayment->value, $processType->value, $filedCaseFather->getValue(), $applicant->getValue(),
                $guideNumber->getValue()
            );

            $filed = $this->filedRepository->create($filed);

            foreach ($documents as $document) {
                $documentDb = new Document(
                    null, $filed->getIdRadicado(), $document->getDocumentId()->getValue(),
                    $document->getEndPointFileNet()->getValue(), $document->getOrderImp()->getValue(),
                    $document->getNumPages()->getValue(), null
                );
                $this->documentRepository->create($documentDb);
            }

            $this->entityManager->flush();
            $this->entityManager->commit();

            return $guideNumber->getValue();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            $this->managerRegistry->resetManager();
            throw $e;
        }
    }
}