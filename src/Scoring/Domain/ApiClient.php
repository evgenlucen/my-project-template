<?php

namespace App\Scoring\Domain;

/**
 * Заглушка, имитирующая ответ стороннего API для упрощения
 */
class ApiClient
{
    public function __construct()
    {
    }


    public function calculateFico(string $ssn): int
    {
        return random_int(300,800);
    }
}