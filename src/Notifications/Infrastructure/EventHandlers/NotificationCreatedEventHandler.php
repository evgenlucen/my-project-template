<?php

namespace App\Notifications\Infrastructure\EventHandlers;

use App\Notifications\Application\Send\SendNotificationCommand;
use App\Notifications\Domain\Event\NotificationCreatedEvent;
use App\Shared\Application\Command\CommandSyncBusInterface;
use App\Shared\Domain\Event\EventHandlerInterface;

class NotificationCreatedEventHandler implements EventHandlerInterface
{
    public function __construct(
        private readonly CommandSyncBusInterface $commandBus,
    ) {
    }

    public function __invoke(NotificationCreatedEvent $event): void
    {
        $this->commandBus->execute(new SendNotificationCommand($event->notificationId));
    }
}