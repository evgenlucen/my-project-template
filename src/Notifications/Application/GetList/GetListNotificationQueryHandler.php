<?php

namespace App\Notifications\Application\GetList;

use App\Notifications\Domain\Notification;
use App\Notifications\Domain\NotificationRepository;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetListNotificationQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly NotificationRepository $notificationRepository)
    {
    }

    /**
     * @return Notification[]
     */
    public function __invoke(GetNotificationListQuery $query): array
    {
        return $this->notificationRepository->getAll();
    }
}
