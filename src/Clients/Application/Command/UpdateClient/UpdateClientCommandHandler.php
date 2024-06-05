<?php

namespace App\Clients\Application\Command\UpdateClient;

use App\Clients\Domain\Client;
use App\Clients\Domain\ClientId;
use App\Clients\Domain\ClientRepository;
use App\Clients\Domain\Email;
use App\Clients\Domain\SSN;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Domain\Event\EventInterface;

class UpdateClientCommandHandler implements CommandHandlerInterface
{

    public function __construct(
        private readonly ClientRepository $clientRepository,
        private readonly EventBusInterface $eventBus,
    )
    {
    }

    public function __invoke(UpdateClientCommand $command): Client //Команда используется синхронно для упрощения возвращаем ответ.
    {
        $client = $this->clientRepository->getById(new ClientId($command->id));

        if (null !== $command->firstName) {
            $client->updateFirstName($command->firstName);
        }

        if (null !== $command->lastName) {
            $client->updateLastName($command->lastName);
        }

        // маловероятно, но если мы достаточно доверяем админу, чтобы он сам мог исправить свою ошибку, можно оставить.
        if (null !== $command->ssn) {
            $clientBySSN = $this->clientRepository->findBySsn(new SSN($command->ssn));

            if ($clientBySSN instanceof Client && $clientBySSN !== $client) {
                throw new \RuntimeException('Указанный SSN уже занят');
            }

            $client->updateSsn(new SSN($command->ssn));
        }

        if (null !== $command->email) {
            $clientByEmail = $this->clientRepository->findByEmail(new Email($command->email));

            if ($clientByEmail instanceof Client && $clientByEmail !== $client) {
                throw new \RuntimeException('Указанный Email уже занят');
            }

            $client->updateEmail(new Email($command->email));
        }

        if (null !== $command->zipCode) {
            $client->updateAddressZipCode($command->zipCode);
        }

        array_map(fn (EventInterface $event) => $this->eventBus->execute($event), $client->releaseEvents());

        return $client;
    }
}