<?php

namespace App\Clients\Domain;

/**
 * Рассчитывает или получает кредитный рейтинг клиента.
 */
interface FicoCalculator
{
    public function calculateFico(Client $client): FICO;
}