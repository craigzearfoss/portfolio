<?php

use Carbon\Carbon;

/**
 * Convert a Y-m-d MySQL formatted date to an m-d-Y formatted date.
 *
 * @param string | null $YmdDate - day in the format Y-m-d
 * @return string | null
 */
if (! function_exists('convertYmdToMdy')) {
    function convertYmdToMdy(string | null $YmdDate): string | null
    {
        if (empty($YmdDate)) {
            return '';
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $YmdDate)->format('m-d-Y');
        } catch (\Exception $e) {
            return $YmdDate;
        }
    }
}

/**
 * Convert an m-d-Y formatted date to a Y-m-d MySQL formatted date.
 *
 * @param string | null $mdYDate - day in the format m-d-Y
 * @return string | null
 */
if (! function_exists('convertMdyToYmd')) {
    function convertMdyToYmd(string | null $mdYDate): string | null
    {
        if (empty($mdYDate)) {
            return '';
        }

        try {
            return Carbon::createFromFormat('m-d-Y', $mdYDate)->format('Y-m-d');
        } catch (\Exception $e) {
            return $mdYDate;
        }
    }
}

/**
 * Convert a MySQL date to the short form specified by the APP_DATE_FORMAT_SHORT .env variable.
 *
 * @param string | null $YmdDate - day in the format Y-m-d
 * @return string | null
 */
if (! function_exists('shortDate')) {
    function shortDate(string|null $YmdDate): string | null
    {
        if (empty($YmdDate)) {
            return '';
        }

        if (!$dateFormat = config( 'app.date_format_short')) {
            $dateFormat = 'm/d/Y';
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $YmdDate)->format($dateFormat);
        } catch (\Exception $e) {
            return $YmdDate;
        }
    }
}

/**
 * Convert a MySQL date-time to the short form specified by the APP_DATE_FORMAT_LONG .env variable.
 *
 * @param string $YmdDate - day in the format Y-m-d H:i:s
 * @return string | null
 */
if (! function_exists('longDate')) {
    function longDate(string|null $YmdDate): string | null
    {
        if (empty($YmdDate)) {
            return '';
        }

        if (!$dateTime = config( 'app.date_format_long')) {
            $dateTime = 'F j, Y';
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $YmdDate)->format($dateTime);
        } catch (\Exception $e) {
            return $YmdDate;
        }
    }
}

/**
 * Convert a MySQL date-time to the short form specified by the APP_DATETIME_FORMAT_SHORT .env variable.
 *
 * @param string|null $YmdHisDateTime - day in the format Y-m-d H:i:s
 * @param bool $includeSeconds
 * @return string | null
 */
if (! function_exists('shortDateTime')) {
    function shortDateTime(string|null $YmdHisDateTime, bool $includeSeconds = false): string | null
    {
        if (empty($YmdHisDateTime)) {
            return '';
        }

        if (!$dateTimeFormat = config( 'app.datetime_format_short')) {
            $dateTimeFormat = 'm/d/Y h:i:s a';
        }

        if (!$includeSeconds) {
            $dateTimeFormat = str_replace(':s', '', $dateTimeFormat);
        }

        try {
            return Carbon::createFromFormat('Y-m-d H:i:s', $YmdHisDateTime)->format($dateTimeFormat);
        } catch (\Exception $e) {
            return $YmdHisDateTime;
        }
    }
}

/**
 * Convert a MySQL date-time to the long form specified by the APP_DATETIME_FORMAT_LONG .env variable.
 *
 * @param string|null $YmdHisDateTime - day in the format Y-m-d H:i:s
 * @param bool $includeSeconds
 * @return string | null
 */
if (! function_exists('longDateTime')) {
    function longDateTime(string|null $YmdHisDateTime, bool $includeSeconds = false): string | null
    {
        if (empty($YmdHisDateTime)) {
            return '';
        }

        if (!$dateTimeFormat = config( 'app.datetime_format_long')) {
            $dateTimeFormat = 'F j, Y h:i:s a';
        }

        if (!$includeSeconds) {
            $dateTimeFormat = str_replace(':s', '', $dateTimeFormat);
        }

        try {
            return Carbon::createFromFormat('Y-m-d H:i:s', $YmdHisDateTime)->format($dateTimeFormat);
        } catch (\Exception $e) {
            return $YmdHisDateTime;
        }
    }
}
