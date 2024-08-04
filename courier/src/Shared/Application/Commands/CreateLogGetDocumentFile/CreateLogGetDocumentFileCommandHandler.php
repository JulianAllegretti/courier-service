<?php

namespace App\Shared\Application\Commands\CreateLogGetDocumentFile;

use App\DocumentManagement\Domain\ValueObjects\Document\DocumentIdValueObject;
use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;
use App\Shared\Application\Creators\LogGetDocumentCreator;
use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Exceptions\MaxLengthException;
use App\Shared\Domain\Exceptions\NullException;
use App\Shared\Domain\ValueObjects\ErrorValueObject;
use App\Shared\Domain\ValueObjects\RequestValueObject;

class CreateLogGetDocumentFileCommandHandler implements CommandHandler
{
    public function __construct(private LogGetDocumentCreator $creator)
    {
    }

    /**
     * @throws MaxLengthException
     * @throws NullException
     */
    public function __invoke(CreateLogGetDocumentFileCommand $command): void
    {
        $commandFiledNumber = new FiledNumberValueObject($command->getFiledNumber());
        $documentId = new DocumentIdValueObject($command->getDocumentId());
        $commandRequest = new RequestValueObject($command->getRequest());
        $commandError = new ErrorValueObject($command->getError());

        $this->creator->__invoke($commandFiledNumber, $documentId, $commandRequest, $commandError);
    }
}