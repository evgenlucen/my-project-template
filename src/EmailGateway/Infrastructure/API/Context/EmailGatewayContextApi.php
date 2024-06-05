<?php

namespace App\EmailGateway\Infrastructure\API\Context;

use Psr\Log\LoggerInterface;

class EmailGatewayContextApi
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public function sendEmail(
        string $recipientEmail,
        string $subject,
        string $content,
    ) {
        //todo implement
        $this->logger->info(
            'EmailGatewayContextApi',
            ['recipient' => $recipientEmail, 'subject' => $subject, 'content' => $content],
        );
    }
}