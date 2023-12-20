<?php

namespace App\Utils;


class StringUtils
{

    /**
     * @param $str
     * @param bool $delNumber
     * @return string
     */
    public static function underscoreToCamelCase($str, bool $delNumber = true): string
    {
        $str = preg_replace('/_/', ' ', $str);
        $str = str_replace(' ', '', ucwords($str));
        if ($delNumber) {
            $str = preg_replace('/\d+/', '', $str);
        }
        return $str;
    }

    /**
     * @param $dbType
     * @return void
     */
    public static function getDbColumnType($dbType): string
    {
        if (strpos($dbType, '(') !== false) {
            $dbType = substr($dbType, 0, strpos($dbType, '('));
        }
        return $dbType;
    }

    /**
     * @param $dbType
     * @return string
     */
    public static function getDbColumnLength($dbType): string
    {
        $start = strpos($dbType, '(') + 1;
        $end = strpos($dbType, ')');
        return substr($dbType, $start, $end - $start);
    }
}
