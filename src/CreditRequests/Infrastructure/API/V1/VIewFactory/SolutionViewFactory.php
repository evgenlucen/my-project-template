<?php

namespace App\CreditRequests\Infrastructure\API\V1\VIewFactory;

use App\CreditProducts\Domain\NegativeSolution;
use App\CreditProducts\Domain\PositiveSolution;
use App\CreditProducts\Domain\Solution;

class SolutionViewFactory
{
    public static function jsonApi(Solution $solution): array
    {
        return match ($solution::class) {
            PositiveSolution::class => self::jsonApiPositiveSolution($solution),
            NegativeSolution::class => self::jsonApiNegativeSolution($solution),
            default => throw new \RuntimeException(
                sprintf('Данный тип решения невозможно отобразить %s', $solution::class),
            )
        };
    }

    public static function jsonApiPositiveSolution(PositiveSolution $solution): array
    {
        return [
            'type' => 'solutions',
            'attributes' => [
                'client' => $solution->getClientId()->toString(),
                'creditProductTitle' => $solution->getCreditProductTitle(),
                'percentRate' => round($solution->getPercentRate()->getValue(), 2),
                'creditAmount' => $solution->getCreditAmount()->getAmount(),
                'periodInMonth' => $solution->getPeriodInMonth()->getValue(),
            ],
        ];
    }

    public static function jsonApiNegativeSolution(NegativeSolution $solution): array
    {
        return [
            'type' => 'solutions',
            'attributes' => [
                'client' => $solution->getClientId()->toString(),
                'creditProductTitle' => $solution->getCreditProductTitle(),
                'rejectMessage' => $solution->getRejectMessage(),
            ],
        ];
    }
}