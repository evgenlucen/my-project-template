<?php

namespace App\Clients\Infrastructure\API\V1\Requests;

use App\Shared\Infrastructure\API\FormatConstants\DateTimeFormat;
use App\Shared\Infrastructure\API\Requests\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class CreateClientRequest extends BaseRequest
{
    #[Assert\NotBlank]
    public string $firstName;

    #[Assert\NotBlank]
    public string $lastName;

    #[Assert\DateTime(format: DATE_RFC3339)]
    #[Assert\NotBlank]
    public string $dateOfBirth;

    #[Assert\NotBlank]
    public string $ssn;

    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\NotBlank]
    public string $phoneNumber;

    #[Assert\NotBlank]
    public string $state;

    #[Assert\NotBlank]
    public string $city;

    #[Assert\NotBlank]
    public string $street;

    #[Assert\NotBlank]
    public string $zipCode;

}