<?php

namespace App\Notifications\Infrastructure\WebController;

use App\Notifications\Application\GetList\GetNotificationListQuery;
use App\Notifications\Infrastructure\Api\V1\ViewFactory\NotificationView;
use App\Shared\Infrastructure\Controller\WebController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/notifications', name: 'web-notifications', methods: ['GET'])]
class NotificationsListWebController extends WebController
{
    public function __invoke(): Response
    {
        $notifications = $this->ask(new GetNotificationListQuery());

        return $this->render(
            templatePath: 'pages/notifications/notifications.html.twig',
            arguments: [
                'title' => 'Уведомления',
                'notifications' => NotificationView::createList($notifications),
                'notifications_counter' => \count($notifications),
            ]
        );
    }

    protected function exceptions(): array
    {
        return [];
    }
}
