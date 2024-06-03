<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Command\CommandAsyncBusInterface;
use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

class CommandAsyncBus implements CommandAsyncBusInterface
{
    private readonly MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /** @param StampInterface[]|array $stamps */
    public function execute(CommandInterface $command, array $stamps = []): void
    {
        $this->commandBus->dispatch($command, $stamps);
    }
}
