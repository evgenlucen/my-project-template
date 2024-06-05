<?php

namespace App\Notifications\Infrastructure\Services;

use App\Notifications\Domain\DeliveryTool;
use App\Notifications\Domain\Notification;
use App\Notifications\Domain\NotificationRepository;
use App\Notifications\Domain\NotificationSender;
use App\Notifications\Infrastructure\Adapters\EmailGatewayAdapter;
use App\Notifications\Infrastructure\Adapters\SmsGatewayAdapter;

class NotificationSenderService implements NotificationSender
{
    public function __construct(
        private readonly EmailGatewayAdapter $emailGatewayAdapter,
        private readonly SmsGatewayAdapter $smsGatewayAdapter,
        private readonly NotificationRepository $notificationRepository,
    ) {
    }

    public function sendNotification(Notification $notification): void
    {
        match ($notification->getDeliveryTool()) {
            DeliveryTool::EMAIL => $this->emailGatewayAdapter->sendEmailNotification($notification),
            DeliveryTool::SMS => $this->smsGatewayAdapter->sendSmsNotification($notification),
            DeliveryTool::TELEGRAM => throw new \RuntimeException(
                'Telegram notification not supported in this app',
            )//$this->telegramBotAdapter->sendNotification($notification),
        };

        $notification->sent();
        $this->notificationRepository->save($notification);
    }
}
