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
use App\DocumentManagement\Domain\ValueObjects\ApplicationIdValueObject;
use App\DocumentManagement\Domain\ValueObjects\EventTriggeredValueObject;
use App\DocumentManagement\Domain\ValueObjects\IdCaseValueObject;
use App\DocumentManagement\Domain\ValueObjects\InputSystemValueObject;
use App\DocumentManagement\Domain\ValueObjects\ProcessNameValueObject;
use App\DocumentManagement\Domain\ValueObjects\SerieValueObject;
use App\DocumentManagement\Domain\ValueObjects\ShippingTypeValueObject;
use App\DocumentManagement\Domain\ValueObjects\SubjectValueObject;
use App\DocumentManagement\Domain\ValueObjects\SubProcessValueObject;
use App\DocumentManagement\Domain\ValueObjects\CellphoneValueObject;
use App\DocumentManagement\Domain\ValueObjects\CodDaneValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\DocumentValueObject;
use App\DocumentManagement\Domain\ValueObjects\ProcessValueObject;
use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\FullNameValueObject;
use App\DocumentManagement\Domain\ValueObjects\GuideNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\Identification\IdentificationValueObject;
use App\DocumentManagement\Domain\ValueObjects\PhoneValueObject;
use App\DocumentManagement\Domain\ValueObjects\PrintedGuideValueObject;
use App\DocumentManagement\Domain\ValueObjects\SubSerieValueObject;
use App\DocumentManagement\Domain\ValueObjects\TraceValueObject;
use App\DocumentManagement\Domain\ValueObjects\TransactionIdValueObject;
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
     * @param DocumentValueObject $document
     * @param FullNameValueObject $fullName
     * @param Priority $priority
     * @param Printed $printed
     * @param TypePortPayment $typePortPayment
     * @param ProcessType $processType
     * @param PortPayment $portPayment
     * @param PhoneValueObject|null $phone
     * @param ProcessValueObject|null $processValueObject
     * @param IdentificationValueObject|null $identification
     * @param CellphoneValueObject|null $cellphone
     * @param SubProcessValueObject|null $subProcessValueObject
     * @param SubjectValueObject|null $subjectValueObject
     * @param ShippingTypeValueObject|null $shippingTypeValueObject
     * @param SerieValueObject|null $serieValueObject
     * @param SubSerieValueObject|null $subSerieValueObject
     * @param InputSystemValueObject|null $inputSystemValueObject
     * @param ApplicationIdValueObject|null $applicationIdValueObject
     * @param TransactionIdValueObject|null $transactionIdValueObject
     * @param IdCaseValueObject|null $idCaseValueObject
     * @param EventTriggeredValueObject|null $eventTriggeredValueObject
     * @param ProcessNameValueObject|null $processNameValueObject
     * @param TraceValueObject|null $traceValueObject
     * @return string
     * @throws MaxLengthException
     * @throws NullException
     */
    public function __invoke(
        FiledNumberValueObject     $filedNumber,
        CodDaneValueObject         $codDane,
        AddressValueObject         $address,
        PrintedGuideValueObject    $printedGuide,
        DocumentValueObject        $document,
        FullNameValueObject        $fullName,
        Priority                   $priority,
        Printed                    $printed,
        TypePortPayment            $typePortPayment,
        ProcessType                $processType,
        PortPayment                $portPayment,
        ?PhoneValueObject          $phone,
        ?ProcessValueObject        $processValueObject,
        ?IdentificationValueObject $identification,
        ?CellphoneValueObject      $cellphone,
        ?SubProcessValueObject     $subProcessValueObject,
        ?SubjectValueObject        $subjectValueObject,
        ?ShippingTypeValueObject   $shippingTypeValueObject,
        ?SerieValueObject          $serieValueObject,
        ?SubSerieValueObject       $subSerieValueObject,
        ?InputSystemValueObject    $inputSystemValueObject,
        ?ApplicationIdValueObject  $applicationIdValueObject,
        ?TransactionIdValueObject  $transactionIdValueObject,
        ?IdCaseValueObject         $idCaseValueObject,
        ?EventTriggeredValueObject $eventTriggeredValueObject,
        ?ProcessNameValueObject    $processNameValueObject,
        ?TraceValueObject          $traceValueObject,
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

            $documentDb = new Document(
                null, $document->getDocumentId()->getValue(), $document->getUrlSeeDocument()->getValue(), null
            );
            $this->documentRepository->create($documentDb);

            $guideNumber = new GuideNumberValueObject($this->guideNumberRepository->updateCurrentNumber());

            $filed = new Filed(
                null, $identificationDb?->getIdIdentificacion(), $documentDb->getIdDocumento(), $filedNumber->getValue(),
                $cellphone->getValue(), $codDane->getValue(), $address->getValue(), $printedGuide->getValue(),
                $fullName->getValue(), $phone->getValue(), $priority->value, $printed->value, $portPayment->value,
                $typePortPayment->value, $processType->value, $processValueObject->getValue(), $subProcessValueObject->getValue(),
                $subjectValueObject->getValue(), $shippingTypeValueObject->getValue(), $serieValueObject->getValue(), $subSerieValueObject->getValue(),
                $inputSystemValueObject->getValue(), $applicationIdValueObject->getValue(), $transactionIdValueObject->getValue(),
                $idCaseValueObject->getValue(), $eventTriggeredValueObject->getValue(), $processNameValueObject->getValue(), $traceValueObject->getValue(),
                $guideNumber->getValue()
            );

            $this->filedRepository->create($filed);

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