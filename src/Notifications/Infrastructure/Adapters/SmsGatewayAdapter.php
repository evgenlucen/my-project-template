<?php

namespace App\Notifications\Infrastructure\Adapters;

use App\Notifications\Domain\Notification;
use App\SmsGateway\Infrastructure\API\Context\SmsGatewayContextApi;

class SmsGatewayAdapter
{
    public function __construct(
        private readonly SmsGatewayContextApi $smsGatewayContextApi,
    ) {
    }

    public function sendSmsNotification(Notification $notification): void
    {
        $this->smsGatewayContextApi->sendSms(
            recipientPhoneNumber: $notification->getRecipient(),
            text: $notification->getContent(),
        );
    }
}