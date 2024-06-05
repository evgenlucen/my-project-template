<?php

namespace App\Credit\CreditRequests\Infrastructure\Persistence\Doctrine\Repository;

use App\Credit\CreditRequests\Domain\CreditRequest;
use App\Credit\CreditRequests\Domain\CreditRequestRepository;
use App\Shared\Infrastructure\Database\Persistence\Doctrine\DoctrineRepository;

class DoctrineCreditRequestRepository extends DoctrineRepository implements CreditRequestRepository
{

    public function save(CreditRequest $creditRequest): void
    {
        $this->persist($creditRequest);
    }
}