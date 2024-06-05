<?php

namespace App\Credit\CreditRequests\Infrastructure\Adapters;

use App\Credit\CreditRequests\Domain\CreditRequest;
use App\Credit\CreditRequests\Infrastructure\Adapters\ViewFactory\CreditRequestNotificationViewFactory;
use App\Notifications\Infrastructure\Api\Context\NotificationsContextApi;
use App\Shared\Domain\Service\DateTimeService;

class NotificationsAdapter
{
    public function __construct(
        private readonly NotificationsContextApi $notificationsContextApi,
        private readonly ClientAdapter $clientAdapter,
    ) {
    }

    public function createNotificationForCreditRequestSolution(CreditRequest $creditRequest): void
    {
        $this->notificationsContextApi->createSmsNotification(
            content: CreditRequestNotificationViewFactory::makeSmsNotificationContent($creditRequest),
            recipient: $this->clientAdapter->getBorrowerPhone($creditRequest->getBorrower()->getId()),
            deliveryTime: DateTimeService::createNow()->modify('+1 second'),
        );


        $this->notificationsContextApi->createEmailNotification(
            content: CreditRequestNotificationViewFactory::makeEmailNotificationContent($creditRequest),
            recipient: $this->clientAdapter->getBorrowerEmail($creditRequest->getBorrower()->getId()),
            deliveryTime: DateTimeService::createNow()->modify('+10 second'),
        );
    }
}