<?php

namespace App\Client\Domain;

use App\Shared\Domain\Service\AssertService;

class SSN
{
    /*
    * This number has the following rules:

        consists of 9 digits and usually divided by 3 parts by hyphen (XXX-XX-XXXX).
        The first part can not be 000, 666, or between 900-900.
        Second part can not be 00
        Third part can not be 0000
    */
    public function __construct(private readonly string $ssn)
    {
       AssertService::regex($this->ssn, "^(?!666|000|9\\d{2})\\d{3}-(?!00)\\d{2}-(?!0{4})\\d{4}$");
    }

    public function getSSN(): string
    {
        return $this->ssn;
    }

    // public function __toString(): string
    // {
    //     return $this->ssn;
    // }
    //
    // public function getValue(): string
    // {
    //     return  $this->ssn;
    // }

    public function toPublicView(): string
    {
        // Вычисляем количество символов, которые нужно замаскировать
        $maskLength = strlen($this->ssn) - 4;
        // Заменяем все символы, кроме последних четырех, на звездочки
        $maskedString = substr_replace($this->ssn, str_repeat('*', $maskLength), 0, $maskLength);
        return $maskedString;
    }
}