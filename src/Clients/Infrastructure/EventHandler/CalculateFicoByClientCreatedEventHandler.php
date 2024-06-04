<?php

namespace App\Clients\Infrastructure\EventHandler;

use App\Clients\Domain\ClientRepository;
use App\Clients\Domain\Events\ClientCreated;
use App\Clients\Domain\FicoCalculator;

/**
 * Рассчитывает кредитный рейтинг клиента после
 * его создания.
 */
class CalculateFicoByClientCreatedEventHandler
{
    public function __construct(
        private readonly FicoCalculator $calculator,
        private readonly ClientRepository $clientRepository,
    )
    {
    }

    public function __invoke(ClientCreated $event): void
    {
        $client = $this->clientRepository->getById($event->clientId);
        $fico = $this->calculator->calculateFico($client);

        $client->updateFico($fico);
        $this->clientRepository->save($client);
    }
}