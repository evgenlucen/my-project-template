<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

interface CommandSyncBusInterface
{
    public function execute(CommandInterface $command): mixed;
}
