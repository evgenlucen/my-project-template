<?php

namespace App\CreditRequests\Application\Command\CreateCreditRequest;

use App\Clients\Domain\ClientId;
use App\Shared\Application\Command\CommandInterface;

class CreateCreditRequestCommand implements CommandInterface
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly int $periodInMonths,
        public readonly float $creditAmount,
    ) {
    }
}