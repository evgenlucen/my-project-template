<?php

namespace App\CreditProducts\Domain\Products;

use App\CreditProducts\Domain\CreditProduct;
use App\CreditProducts\Domain\NegativeSolution;
use App\CreditProducts\Domain\PercentRate;
use App\CreditProducts\Domain\PositiveSolution;
use App\CreditProducts\Domain\Solution;
use App\CreditRequests\Domain\CreditRequest;

/**
 * Реализация простого кредитного продукта.
 * Отвечает за:
 * 1. хранение конфигурации правил, которые применяются при формировании Решения (Solution),
 * 2. калькуляцию решения по Кредитной заявке (CreditRequest)
 */
class SomeCreditProduct implements CreditProduct
{

    public const TITLE = 'SomeCreditProduct';

    const OVERSTAFFING_STATE = 'CA';

    const RATE_SUPPLEMENT = 11.49;

    public const BASE_PERCENT_RATE = 10.00;

    public array $approvedStates = ['CA', 'NY', 'NV'];

    public const RANDOM_REJECT_STATE = 'NY';

    public const FICO_MINIMAL = 500;

    public const AGE_MAX = 60;

    public const AGE_MIN = 18;

    private function __construct(
        private readonly string $title,
        private readonly PercentRate $basePercentRate, // базовая процентная ставка
    )
    {
    }

    public static function create(): self
    {
        return new self(
            title: self::TITLE,
            basePercentRate: new PercentRate(self::BASE_PERCENT_RATE),
        );
    }

    public function calculateSolution(CreditRequest $creditRequest): Solution
    {
        if ($creditRequest->getClient()->getFico()?->isLessThat(self::FICO_MINIMAL)) {
            return new NegativeSolution(
                client: $creditRequest->getClient(),
                creditProductTitle: self::TITLE,
                rejectMessage: 'Ваш кредитный рейтинг слишком мал',
            );
        }

        if ($creditRequest->getClient()->getDateOfBirth()->getAge() > self::AGE_MAX
            || $creditRequest->getClient()->getDateOfBirth()->getAge() < self::AGE_MIN) {
            return new NegativeSolution(
                client: $creditRequest->getClient(),
                creditProductTitle: self::TITLE,
                rejectMessage: 'Кредит выдается клиентам от 18 до 60 лет',
            );
        }

        if (!\in_array($creditRequest->getClient()->getAddress()->getState(), $this->approvedStates)) {
            return new NegativeSolution(
                client: $creditRequest->getClient(),
                creditProductTitle: self::TITLE,
                rejectMessage: 'В вашем штате кредит не выдается',
            );
        }

        if ($creditRequest->getClient()->getAddress()->getState() === self::RANDOM_REJECT_STATE) {
            return new NegativeSolution(
                client: $creditRequest->getClient(),
                creditProductTitle: self::TITLE,
                rejectMessage: 'Вам не повезло. Смените прописку или попробуйте ещё раз',
            );
        }

        if ($creditRequest->getClient()->getAddress()->getState() === self::OVERSTAFFING_STATE) {
            return new PositiveSolution(
                client: $creditRequest->getClient(),
                creditProductTitle: $this->title,
                percentRate: $this->basePercentRate->increaseBy(self::RATE_SUPPLEMENT),
                creditAmount: $creditRequest->getCreditAmount(),
                periodInMonth: $creditRequest->getPeriodInMonths(),
            );
        }

        return new PositiveSolution(
            client: $creditRequest->getClient(),
            creditProductTitle: $this->title,
            percentRate: $this->basePercentRate,
            creditAmount: $creditRequest->getCreditAmount(),
            periodInMonth: $creditRequest->getPeriodInMonths(),
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBasePercentRate(): PercentRate
    {
        return $this->basePercentRate;
    }

}