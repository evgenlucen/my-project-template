<?php

namespace App\AmoCrmFacade\Infrastructure\ApiClient;

use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class FileTokenRepository implements TokenRepository
{
    public function __construct(private readonly string $accessTokenFile)
    {
    }

    public function save(AccessTokenInterface $accessToken): void
    {
        file_put_contents($this->accessTokenFile, json_encode($accessToken));
    }

    public function get(): ?AccessTokenInterface
    {
        if (!file_exists($this->accessTokenFile)
            || false === file_get_contents($this->accessTokenFile))
        {
            return null;
        }

        $fileContent = file_get_contents($this->accessTokenFile);
        $data = \json_decode($fileContent, true, JSON_THROW_ON_ERROR, JSON_THROW_ON_ERROR);

        return new AccessToken($data);
    }
}
