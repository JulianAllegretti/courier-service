<?php

namespace App\DocumentManagement\Application\Commands\CreateInformation;

use App\DocumentManagement\Application\Creators\FiledCreator;
use App\DocumentManagement\Domain\Repository\GuideNumberRepository;
use App\DocumentManagement\Domain\ValueObjects\AddressValueObject;
use App\DocumentManagement\Domain\ValueObjects\ApplicantValueObject;
use App\DocumentManagement\Domain\ValueObjects\CellphoneValueObject;
use App\DocumentManagement\Domain\ValueObjects\CodDaneValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\DocumentIdValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\DocumentValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\EndPointFileNetValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\NumPagesValueObject;
use App\DocumentManagement\Domain\ValueObjects\Document\OrderImpValueObject;
use App\DocumentManagement\Domain\ValueObjects\FiledCaseFatherValueObject;
use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\FullNameValueObject;
use App\DocumentManagement\Domain\ValueObjects\GuideNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\Identification\DocumentNumberValueObject;
use App\DocumentManagement\Domain\ValueObjects\Identification\IdentificationValueObject;
use App\DocumentManagement\Domain\ValueObjects\PhoneValueObject;
use App\DocumentManagement\Domain\ValueObjects\PrintedGuideValueObject;
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
     * @throws Exception
     * @throws NullException
     * @throws ORMException
     */
    public function __invoke(CreateInformationCommand $command): void
    {
        $commandFiledNumber = new FiledNumberValueObject($command->getFiledNumber());
        $commandCodDane = new CodDaneValueObject($command->getCodDane());
        $commandCellphone = new CellphoneValueObject($command->getCellphone() != '' ? $command->getCellphone() : null);
        $commandAddress = new AddressValueObject($command->getAddress());
        $commandPrintedGuide = new PrintedGuideValueObject($command->getPrintedGuide());
        $commandFullName = new FullNameValueObject($command->getFullName());
        $commandPhone = new PhoneValueObject($command->getPhone() != '' ? $command->getPhone() : null);
        $commandFiledCaseFather = new FiledCaseFatherValueObject($command->getFiledCaseFather() != '' ? $command->getFiledCaseFather() : null);
        $commandApplicant = new ApplicantValueObject($command->getApplicant() != '' ? $command->getApplicant() : null);

        $commandIdentification = null;
        if ($command->getIdentification() !== null) {
            $commandDocumentIdentification = new DocumentNumberValueObject($command->getIdentification()->getDocumento());
            $commandIdentification = new IdentificationValueObject(
                $commandDocumentIdentification, $command->getIdentification()->getDocumentTypeEnum()
            );
        }

        $documents = [];
        foreach ($command->getDocuments() as $document) {
            $documentId = new DocumentIdValueObject($document->getIdDocumento());
            $documentEndPoint = new EndPointFileNetValueObject($document->getEndPointFileNet());
            $documentOrderImp = new OrderImpValueObject($document->getOrdenImp());
            $documentNumPages = new NumPagesValueObject($document->getNumPaginas());

            $documents[] = new DocumentValueObject(
                $documentId, $documentEndPoint, $documentOrderImp, $documentNumPages
            );
        }

        $guideNumber = $this->creator->__invoke(
            $commandFiledNumber, $commandCodDane, $commandAddress, $commandPrintedGuide, $documents,
            $commandFullName, $command->getPriority(), $command->getPrinted(), $command->getTypePortPayment(),
            $command->getProcessType(), $command->getPortPayment(), $commandPhone,
            $commandFiledCaseFather, $commandIdentification, $commandCellphone, $commandApplicant
        );

        $command->setGuideNumber($guideNumber);
    }
}