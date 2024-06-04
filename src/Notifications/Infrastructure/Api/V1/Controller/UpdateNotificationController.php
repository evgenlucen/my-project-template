<?php

namespace App\Notifications\Infrastructure\Api\V1\Controller;

use App\Notifications\Application\Update\UpdateNotificationCommand;
use App\Notifications\Domain\Notification;
use App\Shared\Application\Command\CommandSyncBusInterface;
use App\Shared\Domain\Formats\ProjectConst;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/notifications/{id}', name: 'create-notification', methods: ['PATCH'])]
class UpdateNotificationController
{
    public function __construct(
        private readonly CommandSyncBusInterface $commandBus,
    ) {
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $data = \json_decode($request->getContent(), true);

        $deliveryTime = \DateTimeImmutable::createFromFormat(ProjectConst::DATETIME_FORMAT_API, $data['deliveryTime']);
        $content = $data['content'] ?? throw new \RuntimeException('Content error');
        $recipient = $data['recipient'] ?? throw new \RuntimeException('Recipient error');

        /** @var Notification $notification */
        $notification = $this->commandBus->execute(
            new UpdateNotificationCommand(
                id: $id,
                deliveryTime: $deliveryTime,
                recipient: $recipient,
                content: $content,
            ),
        );

        return new JsonResponse(['message' => sprintf('Уведомление %s обновлено', $notification->getId())]);
    }
}
