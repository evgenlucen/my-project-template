<?php

namespace App\Notifications\Application\Create;

use App\Notifications\Domain\DeliveryStatus;
use App\Notifications\Domain\DeliveryTool;
use App\Shared\Application\Command\CommandInterface;

/**
 * @see CreateNotificationCommandHandler
 */
class CreateNotificationCommand implements CommandInterface
{
    public function __construct(
        public readonly string $content,
        public readonly string $recipient,
        public readonly DeliveryTool $deliveryTool,
        public readonly \DateTimeImmutable $deliveryTime,
    ) {
    }
}
