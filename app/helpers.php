<?php

if (! function_exists('toPreferredTimezone')) {
    function toPreferredTimezone(string $date, string $defaultTimezone = 'UTC'): string
    {
        $d = new DateTime(str_replace('-', '/', $date), new DateTimeZone($defaultTimezone));
        $d->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'America/New_York')));

        return $d->format('m/d/Y H:i:s T');
    }
}

function tirePressureConvert(mixed $tirePressure): int|float
{
    return round($tirePressure * 0.1450377, 0) ?? -1;
}
