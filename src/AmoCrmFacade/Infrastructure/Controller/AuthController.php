<?php

namespace App\AmoCrmFacade\Infrastructure\Controller;

use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Exceptions\BadTypeException;
use App\AmoCrmFacade\Infrastructure\ApiClient\Auth;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/amocrm/auth', name: 'amocrm-auth')]
class AuthController
{
    public function __construct(private readonly Auth $auth)
    {
    }

    /**
     * @throws InvalidArgumentException
     * @throws BadTypeException
     * @throws AmoCRMoAuthApiException
     */
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['data' => ['ownerName' => $this->auth->run()]]);
    }
}
