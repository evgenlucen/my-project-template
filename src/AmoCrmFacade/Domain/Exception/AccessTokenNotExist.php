<?php

namespace App\AmoCrmFacade\Domain\Exception;

use Throwable;

class AccessTokenNotExist extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}