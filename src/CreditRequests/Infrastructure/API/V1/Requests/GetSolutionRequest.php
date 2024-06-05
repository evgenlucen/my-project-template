<?php

namespace App\CreditRequests\Infrastructure\API\V1\Requests;

use App\Shared\Infrastructure\API\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class GetSolutionRequest extends BaseRequest
{
    #[Assert\NotBlank]
    public string $clientId;

    #[Assert\NotBlank]
    public int $periodInMonths;

    #[Assert\NotBlank]
    public float $creditAmount;
}