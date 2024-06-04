<?php

namespace App\Notifications\Application\Send;

use App\Shared\Application\Command\CommandInterface;

/**
 * @see SendNotificationCommandHandler
 */
class SendNotificationCommand implements CommandInterface
{
    public function __construct(public readonly string $notificationId)
    {
    }
}
