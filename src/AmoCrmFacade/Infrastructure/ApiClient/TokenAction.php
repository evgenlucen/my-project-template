<?php

namespace App\AmoCrmFacade\Infrastructure\ApiClient;

use App\AmoCrmFacade\Domain\Exception\AccessTokenFileNotFound;
use App\AmoCrmFacade\Domain\Exception\InvalidAccessToken;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Не используется. @see FileTokenRepository.
 */
class TokenAction
{
    final public const TOKEN_FILE = __DIR__.'../../../../amo_access_token.json';

    /**
     * @param array<mixed> $accessToken
     */
    public static function saveToken(array $accessToken): void
    {
        if (
            isset($accessToken['refreshToken']) && isset($accessToken['accessToken']) && isset($accessToken['baseDomain']) && isset($accessToken['expires'])
        ) {
            $data = [
                'accessToken' => $accessToken['accessToken'],
                'expires' => $accessToken['expires'],
                'refreshToken' => $accessToken['refreshToken'],
                'baseDomain' => $accessToken['baseDomain'],
            ];

            file_put_contents(self::TOKEN_FILE, json_encode($data));
        } else {
            throw new InvalidAccessToken('Invalid access token '.var_export($accessToken, true));
        }
    }

    public static function getToken(): AccessToken
    {
        if (!file_exists(self::TOKEN_FILE)) {
            throw new AccessTokenFileNotFound(sprintf('Access token file not found: %s', self::TOKEN_FILE));
        }

        $accessToken = json_decode(file_get_contents(self::TOKEN_FILE), true);

        if (
            isset($accessToken['refreshToken']) && isset($accessToken['accessToken']) && isset($accessToken['baseDomain']) && isset($accessToken['expires'])
        ) {
            return new AccessToken([
                'access_token' => $accessToken['accessToken'],
                'refresh_token' => $accessToken['refreshToken'],
                'expires' => $accessToken['expires'],
                'baseDomain' => $accessToken['baseDomain'],
            ]);
        } else {
            exit('Invalid access token '.var_export($accessToken, true));
        }
    }
}
