<?php

namespace App\AmoCrmFacade\Infrastructure\ApiClient;

use AmoCRM\Client\AmoCRMApiClient;
use App\AmoCrmFacade\Domain\Exception\AccessTokenNotExist;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class ApiProvider
{
    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly string $redirectUri,
        private readonly TokenRepository $tokenRepository,
    ) {
    }

    public function getApiClient(): AmoCRMApiClient
    {
        $apiClient = new AmoCRMApiClient($this->clientId, $this->clientSecret, $this->redirectUri);

        $accessToken = $this->tokenRepository->get() ?? throw new AccessTokenNotExist('AmoCRM Access Token not exist');

        $apiClient->setAccessToken($accessToken)
            ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken, string $baseDomain) {
                    $this->tokenRepository->save(new AccessToken([
                        'access_token' => $accessToken->getToken(),
                        'refresh_token' => $accessToken->getRefreshToken(),
                        'expires' => $accessToken->getExpires(),
                        'baseDomain' => $baseDomain,
                    ]));
                }
            );

        return $apiClient;
    }

    public function getNotAuthApiClient(): AmoCRMApiClient
    {
        return new AmoCRMApiClient($this->clientId, $this->clientSecret, $this->redirectUri);
    }
}
