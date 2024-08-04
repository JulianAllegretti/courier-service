<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Command;
use App\Shared\Domain\CommandBus;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

readonly class SymfonyCommandBus implements CommandBus
{
    private MessageBus $bus;

    public function __construct(iterable $commandHandlers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(CallableFirstParameterExtractor::forCallables($commandHandlers))
                ),
            ]
        );
    }

    /**
     * @throws \Throwable
     * @throws ExceptionInterface
     */
    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (Exception $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}