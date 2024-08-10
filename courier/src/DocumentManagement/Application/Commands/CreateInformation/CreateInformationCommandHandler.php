<?php

namespace App\DocumentManagement\Application\Commands\CreateInformation;

use App\DocumentManagement\Application\Creators\FiledCreator;
use App\DocumentManagement\Domain\Repository\GuideNumberRepository;
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
use App\DocumentManagement\Domain\ValueObjects\Document\DocumentIdValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\DocumentValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\UrlSeeDocument;
use App\DocumentManagement\Domain\ValueObjects\Document\NumPagesValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\OrderImpValueObject;
use App\DocumentManagement\Domain\ValueObjects\ProcessValueObject;
use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\FullNameValueObject;
use App\DocumentManagement\Domain\ValueObjects\GuideNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\Identification\DocumentNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\Identification\IdentificationValueObject;
use App\DocumentManagement\Domain\ValueObjects\PhoneValueObject;
use App\DocumentManagement\Domain\ValueObjects\PrintedGuideValueObject;
use App\DocumentManagement\Domain\ValueObjects\SubSerieValueObject;
use App\DocumentManagement\Domain\ValueObjects\TraceValueObject;
use App\DocumentManagement\Domain\ValueObjects\TransactionIdValueObject;
use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Exceptions\MaxLengthException;
use App\Shared\Domain\Exceptions\NullException;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;

class CreateInformationCommandHandler implements CommandHandler
{

    public function __construct(private FiledCreator $creator)
    {
    }

    /**
     * @throws MaxLengthException
     * @throws NullException
     * @throws \Exception
     */
    public function __invoke(CreateInformationCommand $command): void
    {
        $commandFiledNumber = new FiledNumberValueObject($command->getFiledNumber());
        $commandCodDane = new CodDaneValueObject($command->getCodDane());
        $commandCellphone = new CellphoneValueObject($command->getCellphone() != '' ? $command->getCellphone() : null);
        $commandAddress = new AddressValueObject($command->getAddress());
        $commandPrintedGuide = new PrintedGuideValueObject($command->getPrintedGuide() != '' ? $command->getPrintedGuide() : null);
        $commandFullName = new FullNameValueObject($command->getFullName());
        $commandPhone = new PhoneValueObject($command->getPhone() != '' ? $command->getPhone() : null);
        $commandProcess = new ProcessValueObject($command->getProcess() != '' ? $command->getProcess() : null);
        $commandSubProcess = new SubProcessValueObject($command->getSubProcess() != '' ? $command->getSubProcess() : null);
        $subject = new SubjectValueObject($command->getSubject());
        $shippingType = new ShippingTypeValueObject($command->getShippingType());
        $serie = new SerieValueObject($command->getSerie() != '' ? $command->getSerie() : null);
        $subSerie = new SubSerieValueObject($command->getSubSerie() != '' ? $command->getSubSerie() : null);
        $inputSystem = new InputSystemValueObject($command->getInputSystem() != '' ? $command->getInputSystem() : null);
        $applicationId = new ApplicationIdValueObject($command->getApplicationID() != '' ? $command->getApplicationID() : null);
        $transactionId = new TransactionIdValueObject($command->getTransactionID() != '' ? $command->getTransactionID() : null);
        $idCase = new IdCaseValueObject($command->getIdCase() != '' ? $command->getIdCase() : null);
        $eventTriggered = new EventTriggeredValueObject($command->getEventTriggered() != '' ? $command->getEventTriggered() : null);
        $processName = new ProcessNameValueObject($command->getProcessName() != '' ? $command->getProcessName() : null);
        $trace = new TraceValueObject($command->getTrace() != '' ? $command->getTrace() : null);

        $commandIdentification = null;
        if ($command->getIdentification() !== null) {
            $commandDocumentIdentification = new DocumentNumberValueObject($command->getIdentification()->getDocumento());
            $commandIdentification = new IdentificationValueObject(
                $commandDocumentIdentification, $command->getIdentification()->getDocumentTypeEnum()
            );
        }

        $document = new DocumentValueObject(
            new DocumentIdValueObject($command->getDocument()->getIdDocumento()),
            new UrlSeeDocument($command->getDocument()->getUrlVerDocumento())
        );

        $guideNumber = $this->creator->__invoke(
            $commandFiledNumber, $commandCodDane, $commandAddress, $commandPrintedGuide, $document,
            $commandFullName, $command->getPriority(), $command->getPrinted(), $command->getTypePortPayment(),
            $command->getProcessType(), $command->getPortPayment(), $commandPhone, $commandProcess,
            $commandIdentification, $commandCellphone, $commandSubProcess, $subject, $shippingType, $serie,
            $subSerie, $inputSystem, $applicationId, $transactionId, $idCase, $eventTriggered, $processName, $trace
        );

        $command->setGuideNumber($guideNumber);
    }
}