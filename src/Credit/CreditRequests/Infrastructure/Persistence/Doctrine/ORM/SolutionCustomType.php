<?php

namespace App\Credit\CreditRequests\Infrastructure\Persistence\Doctrine\ORM;

use App\Credit\CreditRequests\Domain\NegativeSolution;
use App\Credit\CreditRequests\Domain\PositiveSolution;
use App\Credit\CreditRequests\Domain\Solution;
use App\Credit\CreditRequests\Domain\SolutionType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

class SolutionCustomType extends JsonType
{
    public function getName(): string
    {
        return 'solution_type';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Solution ? \json_encode($value) : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Solution
    {
        if (!is_string($value)) {
            return null;
        }
        $solutionInArray = \json_decode($value, true, JSON_THROW_ON_ERROR);

        $type = SolutionType::from($solutionInArray['type']);

        return match ($type) {
            SolutionType::POSITIVE => PositiveSolution::fromPrimitives($solutionInArray),
            SolutionType::NEGATIVE => NegativeSolution::fromPrimitives($solutionInArray),
        };
    }


}