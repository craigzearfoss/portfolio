<?php

use Carbon\Carbon;

if (! function_exists('convertYmdToMdy')) {
    /**
     * Convert a Y-m-d MySQL formatted date to an m-d-Y formatted date.
     *
     * @param string|null $YmdDate - day in the format Y-m-d
     * @return string|null
     */
    function convertYmdToMdy(string|null $YmdDate): string|null
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

if (! function_exists('convertMdyToYmd')) {
    /**
     * Convert an m-d-Y formatted date to a Y-m-d MySQL formatted date.
     *
     * @param string|null $mdYDate - day in the format m-d-Y
     * @return string|null
     */
    function convertMdyToYmd(string|null $mdYDate): string|null
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

if (! function_exists('shortDate')) {
    /**
     * Convert a MySQL date to the short form specified by the APP_DATE_FORMAT_SHORT .env variable.
     *
     * @param string|null $YmdDate - day in the format Y-m-d
     * @return string|null
     */
    function shortDate(string|null $YmdDate): string|null
    {
        if (empty($YmdDate)) {
            return '';
        }
        $YmdDate = explode(' ', $YmdDate)[0];

        if (!$dateFormat = config( 'app.date_format_short')) {
            $dateFormat = 'm/d/Y';
        }

        if (count(explode('-', $YmdDate)) == 2) {
            // Assume the date only has a year and a month, but no day like 'Y-m'.
            $YmdDate = $YmdDate . '-01';
            $dateFormat = 'm/Y';
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $YmdDate)->format($dateFormat);
        } catch (\Exception $e) {
            return $YmdDate;
        }
    }
}

if (! function_exists('longDate')) {
    /**
     * Convert a MySQL date-time to the short form specified by the APP_DATE_FORMAT_LONG .env variable.
     *
     * @param string|null $YmdDate - day in the format Y-m-d H:i:s
     * @param bool $useThreeLetterMonth
     * @return string|null
     */
    function longDate(?string $YmdDate, bool $useThreeLetterMonth = false): string|null
    {
        if (empty($YmdDate)) {
            return '';
        }
        $YmdDate = explode(' ', $YmdDate)[0];

        if (!$dateFormat = config( 'app.date_format_long')) {
            $dateFormat = 'F j, Y';
        }

        if (count(explode('-', $YmdDate)) == 2) {
            // Assume the date only has a year and a month, but no day like 'Y-m'.
            $YmdDate = $YmdDate . '-01';
            $dateFormat = 'F Y';
        }

        if ($useThreeLetterMonth) {
            $dateFormat = str_replace('F', 'M', $dateFormat);
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $YmdDate)->format($dateFormat);
        } catch (\Exception $e) {
            return $YmdDate;
        }
    }
}

if (! function_exists('shortDateTime')) {
    /**
     * Convert a MySQL date-time to the short form specified by the APP_DATETIME_FORMAT_SHORT .env variable.
     *
     * @param string|null $YmdHisDateTime - day in the format Y-m-d H:i:s
     * @param bool $includeSeconds
     * @return string|null
     */
    function shortDateTime(string|null $YmdHisDateTime, bool $includeSeconds = false): string|null
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

if (! function_exists('longDateTime')) {
    /**
     * Convert a MySQL date-time to the long form specified by the APP_DATETIME_FORMAT_LONG .env variable.
     *
     * @param string|null $YmdHisDateTime - day in the format Y-m-d H:i:s
     * @param bool $includeSeconds
     * @return string|null
     */
    function longDateTime(string|null $YmdHisDateTime, bool $includeSeconds = false): string|null
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

if (! function_exists('months')) {
    /**
     * Returns an array for months.
     *
     * @param bool $includeBlank
     * @return array
     */
    function months($includeBlank = false): array
    {
        $m = [];
        if ($includeBlank) {
            $m[0] = '';
        }

        $m[1] = 'January';
        $m[2] = 'February';
        $m[3] = 'March';
        $m[4] = 'April';
        $m[5] = 'May';
        $m[6] = 'June';
        $m[7] = 'July';
        $m[8] = 'August';
        $m[9] = 'September';
        $m[10] = 'October';
        $m[11] ='November';
        $m[12] = 'December';

        return $m;
    }
}
