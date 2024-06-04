<?php

namespace App\CreditRequests\Domain;

interface CreditRequestRepository
{
    public function save(CreditRequest $creditRequest): void;
}