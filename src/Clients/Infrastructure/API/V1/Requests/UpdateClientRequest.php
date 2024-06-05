<?php

namespace App\Clients\Infrastructure\API\V1\Requests;

use App\Shared\Infrastructure\API\FormatConstants\DateTimeFormat;
use App\Shared\Infrastructure\API\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateClientRequest extends BaseRequest
{
    #[Assert\Length(min: 2,max: 100)]
    public ?string $firstName = null;

    #[Assert\Length(min: 2,max: 100)]
    public ?string $lastName = null;

    public ?string $ssn = null;

    #[Assert\Email]
    public ?string $email = null;

    public ?string $zipCode = null;

}