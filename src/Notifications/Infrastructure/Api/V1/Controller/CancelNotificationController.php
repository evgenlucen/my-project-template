<?php

namespace App\Notifications\Infrastructure\Api\V1\Controller;

use App\Notifications\Application\Cancel\CancelNotificationCommand;
use App\Shared\Application\Command\CommandSyncBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/notification:cancel/{id}', name: 'cancel-notification', methods: ['PATCH'])]
class CancelNotificationController
{
    public function __construct(
        private readonly CommandSyncBusInterface $commandBus,
    ) {
    }

    public function __invoke(string $id): JsonResponse
    {
        $this->commandBus->execute(
            new CancelNotificationCommand(
                notificationId: $id,
            ),
        );

        return new JsonResponse(['message' => sprintf('Доставка уведомления %s отменена', $id)]);
    }
}
