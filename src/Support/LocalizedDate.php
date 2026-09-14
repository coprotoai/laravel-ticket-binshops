<?php

namespace Binshops\LaravelTicket\Support;

use Illuminate\Support\Carbon;

/**
 * Replaces jenssegers/date (abandoned since 2020, permanently capped at
 * Carbon 2 — incompatible with Laravel 12's mandatory Carbon 3). That package
 * never implemented its own translation logic; it only wired Carbon's own
 * extension hooks to Carbon's own built-in translatedFormat() and
 * locale-aware parsing. This class does the same, with no external
 * dependency, so future Laravel/Carbon upgrades can't strand it again.
 */
class LocalizedDate extends Carbon
{
    protected static $formatFunction = 'translatedFormat';
    protected static $createFromFormatFunction = 'createFromFormatWithCurrentLocale';
    protected static $parseFunction = 'parseWithCurrentLocale';

    public static function parseWithCurrentLocale($time = null, $timezone = null)
    {
        if (is_string($time)) {
            $time = static::translateTimeString($time, static::getLocale(), 'en');
        }

        return parent::rawParse($time, $timezone);
    }

    public static function createFromFormatWithCurrentLocale($format, $time = null, $timezone = null)
    {
        if (is_string($time)) {
            $time = static::translateTimeString($time, static::getLocale(), 'en');
        }

        return parent::rawCreateFromFormat($format, $time, $timezone);
    }
}
