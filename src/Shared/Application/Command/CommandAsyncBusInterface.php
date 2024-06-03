<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

use Symfony\Component\Messenger\Stamp\StampInterface;

/** CommandSyncBus для Асинхронных команд */
interface CommandAsyncBusInterface
{
    /** @param StampInterface[]|array $stamps */
    public function execute(CommandInterface $command, array $stamps = []): void;
}
