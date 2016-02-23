<?php

namespace Acme\Component\Common\Utility;

class Converter
{
    /**
     * Convert object to boolean value.
     *
     * @param mixed $obj
     * @return bool
     */
    public static function toBoolean($obj)
    {
        return filter_var($obj, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Convert object to int value.
     *
     * @param $obj
     * @param bool $safeConvert
     * @return int
     */
    public static function toInt($obj, $safeConvert = true)
    {
        $result = filter_var($obj, FILTER_VALIDATE_INT);

        if (false === $result && !$safeConvert) {
            throw new \InvalidArgumentException("Cannot convert $obj to int value.");
        }

        return $result;
    }

    /**
     * Convert object to float value.
     *
     * @param $obj
     * @param bool $safeConvert
     * @return mixed
     */
    public static function toFloat($obj, $safeConvert = true)
    {
        $result = filter_var($obj, FILTER_VALIDATE_FLOAT);

        if (false === $result && !$safeConvert) {
            throw new \InvalidArgumentException("Cannot convert $obj to float value.");
        }

        return $result;
    }

    /**
     * Convert object to string value.
     *
     * @param $obj
     * @return string
     */
    public static function toString($obj)
    {
        return strval($obj);
    }
}
