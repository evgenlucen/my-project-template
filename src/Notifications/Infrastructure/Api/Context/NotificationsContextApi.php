<?php

namespace App\Notifications\Infrastructure\Api\Context;

use App\Notifications\Application\Create\CreateNotificationCommand;
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

    public function createSmsNotification(
        string $content,
        string $recipient,
        \DateTimeImmutable $deliveryTime,
    )
    {
        return $this->commandBus->execute(new CreateNotificationCommand(
            content: $content,
            recipient: $recipient,
            deliveryTool: DeliveryTool::SMS,
            deliveryTime: $deliveryTime,
        ));
    }

    public function createEmailNotification(
        string $content,
        string $recipient,
        \DateTimeImmutable $deliveryTime,
    )
    {
        return $this->commandBus->execute(new CreateNotificationCommand(
            content: $content,
            recipient: $recipient,
            deliveryTool: DeliveryTool::EMAIL,
            deliveryTime: $deliveryTime,
        ));
    }
}
