<?php

declare(strict_types=1);

namespace App\Utils;

use DateTimeImmutable;
use DateTimeZone;

final class DateTimeUtils
{
    public static function createNow(): DateTimeImmutable
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return new DateTimeImmutable('now', self::getTimeZone());
    }

    public static function getTimeZone(): DateTimeZone
    {
        return new DateTimeZone('Europe/Bratislava');
    }
}
