<?php

namespace App\Clients\Domain;

use App\Shared\Domain\Service\AssertService;

/**
 * Не разбирался детально
 * как должен выглядеть адрес, для упрощения реализовано первичное представление
 */
class AddressInUSA
{
    public function __construct(
        private readonly string $street,
        private readonly string $city,
        private readonly string $state,
        private readonly string $zipCode,
    ) {
        AssertService::regex($this->zipCode, '/^[0-9]{5}([- ]?[0-9]{4})?$/');
        AssertService::lengthBetween(
            $this->city,
            2,
            100,
            'Название города должно быть не короче 2х и не длиннее 100 символов',
        );
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function __toString(): string
    {
        return sprintf('%s, %s, %s, %s', $this->city, $this->street, $this->state, $this->zipCode);
    }

}