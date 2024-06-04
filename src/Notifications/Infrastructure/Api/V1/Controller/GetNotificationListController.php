<?php

namespace App\Notifications\Infrastructure\Api\V1\Controller;

use App\Notifications\Application\GetList\GetNotificationListQuery;
use App\Notifications\Infrastructure\Api\V1\ViewFactory\NotificationView;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/notifications', name: 'get-notifications', methods: ['GET'])]
class GetNotificationListController
{
    public function __construct(
        private readonly NotificationView $notificationView,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $notificationList = $this->queryBus->execute(new GetNotificationListQuery());

        $result = [];

        foreach ($notificationList as $notification) {
            $result[] = $this->notificationView->createView($notification);
        }

        return new JsonResponse($result);
    }
}
