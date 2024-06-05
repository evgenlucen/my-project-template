<?php

namespace App\Credit\CreditRequests\Domain;

interface CreditRequestRepository
{
    public function save(CreditRequest $creditRequest): void;
}