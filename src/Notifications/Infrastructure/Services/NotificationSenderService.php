<?php

namespace App\Notifications\Infrastructure\Services;

use App\Notifications\Domain\DeliveryTool;
use App\Notifications\Domain\Notification;
use App\Notifications\Domain\NotificationSender;

class NotificationSenderService implements NotificationSender
{
    public function __construct()
    {
    }

    public function sendNotification(Notification $notification): void
    {
        // if (DeliveryTool::TELEGRAM == $notification->getDeliveryTool()) {
        //     $this->telegramBotAdapter->sendNotification($notification);
        // }
        //todo implement
    }
}
