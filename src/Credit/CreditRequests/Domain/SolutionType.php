<?php

namespace App\Credit\CreditRequests\Domain;

enum SolutionType: string
{
    case POSITIVE = 'positive';

    case NEGATIVE = 'negative';
}