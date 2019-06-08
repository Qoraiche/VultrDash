<?php


if (!function_exists('formatBytes')) {
    function formatBytes($size, $showSuffix = true, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];

        if ($showSuffix) {
            return round(pow(1024, $base - floor($base)), $precision).' '.$suffixes[floor($base)];
        }

        return round(pow(1024, $base - floor($base)), $precision);
    }
}

if (!function_exists('getletters')) {
    function getletters($string)
    {
        $words = explode(' ', $string);
        $acronym = '';

        foreach ($words as $w) {
            $acronym .= $w[0];
        }

        return $acronym;
    }
}

if (!function_exists('dateHelper')) {
    function dateHelper($datestr, $format)
    {
        $strtotime = strtotime($datestr, time());
        $date = date($format, $strtotime);

        return $date;
    }
}

if (!function_exists('ArrayObj')) {
    function ArrayObj($array)
    {
        return json_decode(json_encode($array), false);
    }
}

if (!function_exists('makeClickableLinks')) {
    function makeClickableLinks($s)
    {
        return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
    }
}

if (!function_exists('getPercent')) {
    function getPercent($first, $second)
    {
        return ($first / $second) * 100;
    }
}

if (!function_exists('sort_objects_by_name')) {
    function sort_objects_by_name($a, $b)
    {
        if ($a->name == $b->name) {
            return 0;
        }

        return ($a->name < $b->name) ? -1 : 1;
    }
}
