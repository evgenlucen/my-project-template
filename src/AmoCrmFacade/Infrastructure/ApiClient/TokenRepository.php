<?php

namespace App\AmoCrmFacade\Infrastructure\ApiClient;

use League\OAuth2\Client\Token\AccessTokenInterface;

interface TokenRepository
{
    public function save(AccessTokenInterface $accessToken): void;

    public function get(): ?AccessTokenInterface;
}
