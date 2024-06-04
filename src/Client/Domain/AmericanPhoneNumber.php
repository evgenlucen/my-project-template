<?php

namespace App\Client\Domain;

use App\Shared\Domain\Service\AssertService;

class AmericanPhoneNumber
{
    public function __construct(private readonly string $phoneNumber)
    {
        // Удаляем все нецифровые символы из номера
        $number = preg_replace('/\D/', '', $phoneNumber);

        // Проверяем, что номер состоит из 10 цифр
        AssertService::regex($number, '/^[2-9]\d{9}$/');
    }

    public function getNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getAreaCode(): string
    {
        return substr($this->phoneNumber, 0, 3);
    }

    public function getCentralOfficeCode(): string
    {
        return substr($this->phoneNumber, 3, 3);
    }

    public function getLineNumber(): string
    {
        return substr($this->phoneNumber, 6, 4);
    }

    public function getValue(): string
    {
        return $this->phoneNumber;
    }
}