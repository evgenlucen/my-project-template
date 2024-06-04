<?php

namespace App\CreditRequests\Infrastructure\Persistence\Doctrine\Repository;

use App\CreditRequests\Domain\CreditRequest;
use App\CreditRequests\Domain\CreditRequestRepository;

class DoctrineCreditRequestRepository implements CreditRequestRepository
{

    public function save(CreditRequest $creditRequest): void
    {
        // TODO: Implement save() method.
    }
}