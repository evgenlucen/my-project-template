<?php

namespace App\AmoCrmFacade\Domain\Exception;

class InvalidAccessToken extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
