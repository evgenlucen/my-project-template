<?php

namespace App\Notifications\Infrastructure\Adapters;

use App\EmailGateway\Infrastructure\API\Context\EmailGatewayContextApi;
use App\Notifications\Domain\Notification;

class EmailGatewayAdapter
{
    public function __construct(
        private readonly EmailGatewayContextApi $emailGatewayContextApi,
    ) {
    }

    public function sendEmailNotification(Notification $notification): void
    {
        $this->emailGatewayContextApi->sendEmail(
            recipientEmail: $notification->getRecipient(),
            subject: 'Default', // Notification приехал из другого проекта. не стал расширять его ради темы письма.
            content: $notification->getContent(),
        );
    }
}