<?php

namespace App\Shared\Application\Commands\CreateLogInsertInformation;

use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;
use App\Shared\Application\Creators\LogInsertCreator;
use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Exceptions\MaxLengthException;
use App\Shared\Domain\Exceptions\NullException;
use App\Shared\Domain\ValueObjects\ErrorValueObject;
use App\Shared\Domain\ValueObjects\RequestValueObject;

class CreateLogInsertInformationCommandHandler implements CommandHandler
{
    public function __construct(private LogInsertCreator $creator)
    {
    }

    /**
     * @throws MaxLengthException
     * @throws NullException
     */
    public function __invoke(CreateLogInsertInformationCommand $command): void
    {
        $commandFiledNumber = new FiledNumberValueObject($command->getFiledNumber());
        $commandRequest = new RequestValueObject($command->getRequest());
        $commandError = new ErrorValueObject($command->getError());

        $this->creator->__invoke($commandFiledNumber, $commandRequest, $commandError);
    }
}