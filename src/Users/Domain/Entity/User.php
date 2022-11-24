<?php

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Service\UlidService;

class User
{
    private string $id;
    private string $email;
    private ?string $password = null;

    public function __construct(string $email)
    {
        $this->id = UlidService::generate();
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

}