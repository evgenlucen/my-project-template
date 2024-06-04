<?php

namespace App\Shared\Domain\Service;

use App\Shared\Domain\Formats\ProjectConst;

class DateTimeService
{
    /**
     * @throws \Exception
     */
    public static function createNow(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', new \DateTimeZone(ProjectConst::TIME_ZONE));
    }
}
