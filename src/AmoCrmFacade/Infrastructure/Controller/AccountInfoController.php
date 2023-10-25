<?php

namespace App\AmoCrmFacade\Infrastructure\Controller;

use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\AmoCrmFacade\Infrastructure\ApiClient\ApiProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AccountInfoController
{
    public function __construct(private readonly ApiProvider $apiProvider)
    {
    }

    /**
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     */
    #[Route(path: '/amocrm/info', name: 'amo-info', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['data' => $this->apiProvider->getApiClient()->account()->getCurrent()->toArray()]);
    }
}
