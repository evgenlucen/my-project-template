<?php

namespace App\Shared\Domain\Formats;

class ProjectConst
{
    final public const DATETIME_FORMAT_API = \DateTimeImmutable::ATOM;
    final public const DATETIME_FORMAT_WEB_VIEW = 'j F Y H:i';

    final public const ONLY_DATE_VIEW = 'd-m-Y'; // для отображения пользователям
    final public const ONLY_TIME_VIEW = 'H:i'; // для отображения пользователям

    final public const TIME_ZONE = 'Europe/Moscow';
}
