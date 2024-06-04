<?php

namespace App\Notifications\Infrastructure;

use App\Notifications\Application\Create\CreateNotificationCommand;
use App\Notifications\Domain\DeliveryStatus;
use App\Notifications\Domain\DeliveryTool;
use App\Shared\Application\Command\CommandSyncBusInterface;

class NotificationsContextApi
{
    public function __construct(
        private readonly CommandSyncBusInterface $commandBus,
    ) {
    }

    public function createTelegramNotification(
        string $content,
        string $recipient,
        \DateTimeImmutable $deliveryTime,
    ): string {
        return $this->commandBus->execute(new CreateNotificationCommand(
            content: $content,
            recipient: $recipient,
            deliveryTool: DeliveryTool::TELEGRAM,
            deliveryTime: $deliveryTime,
        ));
    }
}
