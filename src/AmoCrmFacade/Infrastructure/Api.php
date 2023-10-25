<?php

namespace App\AmoCrmFacade\Infrastructure;

use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use App\AmoCrmFacade\Infrastructure\ApiClient\ApiProvider;

class Api
{
    public function __construct(private readonly ApiProvider $apiProvider)
    {
    }

    /**
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     */
    public function getLeads(LeadsFilter $filter): ?LeadsCollection
    {
        return $this->apiProvider->getApiClient()->leads()->get($filter, ['contacts']);
    }

    public function getCustomFieldValue(CustomFieldsValuesCollection $customFieldsValues, int $field_id): mixed
    {
        $field = $customFieldsValues->getBy('fieldId', $field_id);

        return $field?->getValues()->first()->getValue();
    }

    public function getPhone(CustomFieldsValuesCollection $fieldsValues): ?string
    {
        $field = $fieldsValues->getBy('fieldCode', 'PHONE');

        return $field?->getValues()->first()->getValue();
    }

    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public function getContactById(int $contactId): ContactModel
    {
        return $this->apiProvider->getApiClient()->contacts()->getOne($contactId);
    }

    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     * @throws AmoCRMoAuthApiException
     * @throws \Exception
     */
    public function getLeadById(int $leadId): LeadModel
    {
        return $this->apiProvider->getApiClient()->leads()->getOne($leadId);
    }
}
