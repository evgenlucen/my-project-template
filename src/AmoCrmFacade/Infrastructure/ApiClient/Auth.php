<?php

namespace App\AmoCrmFacade\Infrastructure\ApiClient;

use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Exceptions\BadTypeException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Cache\InvalidArgumentException;

class Auth
{
    public function __construct(
        private readonly ApiProvider $apiProvider,
        private readonly TokenRepository $tokenRepository,
    ) {
    }

    /**
     * @throws BadTypeException
     * @throws InvalidArgumentException
     * @throws AmoCRMoAuthApiException
     * @throws \Exception
     */
    public function run(): string
    {
        session_start();
        $apiClient = $this->apiProvider->getNotAuthApiClient();

        if (isset($_GET['referer'])) {
            $apiClient->setAccountBaseDomain($_GET['referer']);
        }

        if (!isset($_GET['code'])) {
            $state = bin2hex(random_bytes(16));
            $_SESSION['oauth2state'] = $state;
            if (isset($_GET['button'])) {
                echo $apiClient->getOAuthClient()->getOAuthButton(
                    [
                        'title' => 'Установить интеграцию',
                        'compact' => true,
                        'class_name' => 'className',
                        'color' => 'default',
                        'error_callback' => 'handleOauthError',
                        'state' => $state,
                    ]
                );
                exit;
            } else {
                $authorizationUrl = $apiClient->getOAuthClient()->getAuthorizeUrl([
                    'state' => $state,
                    'mode' => 'post_message',
                ]);
                header('Location: '.$authorizationUrl);
                exit;
            }
        } elseif (empty($_GET['state'])) {
            throw new \Exception('Invalid state');
        }

        /*
         * Ловим обратный код
         */
        $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($_GET['code']);

        if (!$accessToken->hasExpired()) {
            $this->tokenRepository->save(new AccessToken([
                'access_token' => $accessToken->getToken(),
                'refresh_token' => $accessToken->getRefreshToken(),
                'expires' => $accessToken->getExpires(),
                'baseDomain' => $apiClient->getAccountBaseDomain(),
            ]));
        }

        $ownerDetails = $apiClient->getOAuthClient()->getResourceOwner($accessToken);

        return $ownerDetails->getName();
    }
}
