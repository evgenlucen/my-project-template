<?php

namespace App\Credit\CreditRequests\Infrastructure\Adapters\ViewFactory;

use App\Credit\CreditRequests\Domain\CreditRequest;
use App\Credit\CreditRequests\Domain\NegativeSolution;
use App\Credit\CreditRequests\Domain\PositiveSolution;

class CreditRequestNotificationViewFactory
{
    public static function makeSmsNotificationContent(CreditRequest $creditRequest): string
    {
        $solution = $creditRequest->getSolution();

        return match ($solution::class) {
            PositiveSolution::class => sprintf(
                'Ваша кредитная заявка: %s на сумму %s одобрена под %s%% годовых',
                $creditRequest->getId(),
                $creditRequest->getCreditAmount()->getAmount(),
                $solution->getPercentRate()->getValue(),
            ),
            NegativeSolution::class => sprintf(
                'К сожалению мы не можем одобрить вашу кредитную заявку %s',
                $creditRequest->getId(),
            ),
        };
    }

    public static function makeEmailNotificationContent(CreditRequest $creditRequest): string
    {
        $solution = $creditRequest->getSolution();

        return match ($solution::class) {
            PositiveSolution::class => sprintf(
                'Ваша кредитная заявка: %s на сумму %s одобрена под %s%% годовых',
                $creditRequest->getId(),
                $creditRequest->getCreditAmount()->getAmount(),
                $solution->getPercentRate()->getValue(),
            ),
            NegativeSolution::class => sprintf(
                'К сожалению мы не можем одобрить вашу кредитную заявку %s',
                $creditRequest->getId(),
            ),
        };
    }
}