<?php

namespace App\Notifications\Domain\Event;

use App\Notifications\Domain\Notification;
use App\Shared\Domain\Event\EventInterface;

class NotificationCreatedEvent implements EventInterface
{
    public function __construct(
        public readonly Notification $notification
    ) {
    }
}
