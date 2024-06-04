<?php

namespace App\Client\Application\Command\CreateClient;

use App\Client\Domain\AddressInUSA;
use App\Client\Domain\Age;
use App\Client\Domain\AmericanPhoneNumber;
use App\Client\Domain\Client;
use App\Client\Domain\ClientRepository;
use App\Client\Domain\Email;
use App\Client\Domain\SSN;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Domain\Event\EventInterface;

class CreateClientCommandHandler implements CommandHandlerInterface
{

    public function __construct(
        private readonly ClientRepository $clientRepository,
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateClientCommand $command): void
    {
        // Предполагаем что уникальность клиента можем достаточно достоверно
        // определить по ssn.
        $ssn = new SSN($command->ssn);
        $client = $this->clientRepository->findBySsn($ssn);

        if ($client instanceof Client) {
            throw new \DomainException(sprintf('Client with ssn %s already exists', $ssn->toPublicView()));
        }

        $client = Client::create(
            firstName: $command->firstName,
            lastName: $command->lastName,
            age: new Age($command->age),
            address: new AddressInUSA(
                street: $command->state,
                city: $command->city,
                state: $command->state,
                zipCode: $command->zipCode,
            ),
            ssn: new SSN($command->ssn),
            fico: null,
            email: new Email($command->email),
            phoneNumber: new AmericanPhoneNumber($command->phoneNumber),
        );

        $this->clientRepository->save($client);

        // в реальном проекте убрать публикацию событий на событие flush из Doctrine
        array_map(fn (EventInterface $event) => $this->eventBus->execute($event), $client->releaseEvents());
    }
}