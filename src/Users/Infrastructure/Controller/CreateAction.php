<?php

namespace App\Users\Infrastructure\Controller;

use App\Users\Application\Command\CreateUser\CreateUserCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/users', methods: ['POST'])]
class CreateAction
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ){
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $command = new CreateUserCommand(
            $data['email'],
            $data['password']
        );

        $this->messageBus->dispatch($command);

        return new JsonResponse(['success' => true, 'data'=> ['message' => 'command in queue']]);
    }

}