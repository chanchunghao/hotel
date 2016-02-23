<?php

namespace Acme\Component\Common\Utility;

class Collection
{
    /**
     * @param $key
     * @param array $arr
     * @param mixed $default
     * @param bool $ignoreEmpty
     * @return mixed
     */
    public static function getValue($key, array $arr, $default = null, $ignoreEmpty = true)
    {
        if (array_key_exists($key, $arr)) {
            return !$ignoreEmpty || $arr[$key] ? $arr[$key] : $default;
        }

        return $default;
    }
}
