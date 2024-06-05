<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\API\FormatConstants;

class DateTimeFormat
{
    public static function api(): string
    {
        return DATE_RFC3339; //Y-m-d\TH:i:sP
    }
}
