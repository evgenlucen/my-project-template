<?php

namespace App\Client\Domain;

/**
 * Рассчитывает или получает кредитный рейтинг клиента.
 */
interface FicoCalculator
{
    public function calculateFico(Client $client): FICO;
}