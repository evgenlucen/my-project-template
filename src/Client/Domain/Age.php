<?php

namespace App\Client\Domain;

use App\Shared\Domain\Service\AssertService;

class Age
{
    public function __construct(
        private readonly int $age
    )
    {
        AssertService::positiveInteger($this->age);
        AssertService::greaterThan($this->age, 120, 'Возраст клиента должен быть в диапозоне от 0 до 120 лет');
    }
}