<?php

namespace App\DocumentManagement\Application\Commands\GetDocumentFile;

use App\DocumentManagement\Domain\Client;
use App\Shared\Domain\CommandHandler;

readonly class GetDocumentFileCommandHandler implements CommandHandler
{
    public function __construct(private Client $client)
    {
    }

    public function __invoke(GetDocumentFileCommand $command): void
    {
        $this->client->get(['DocumentId' => $command->getDocumentId()]);
    }
}