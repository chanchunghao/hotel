<?php

namespace Acme\Component\Common\Utility;

/**
 * String Utilities:
 *
 *  - Generate a string: accord/random/format
 *
 *  - Information about a string: startsWith/endsWith/isIp/isEmail/isUrl/isNullOrEmpty/isNullOrWhiteSpace
 *
 *  - Fetch from a string: contains/slice/sliceFrom/sliceTo/baseClass
 *
 *  - Alter a string: limit/words/remove/replace/split/lower/upper/plural/singular/title/canonicalize
 *
 *  - Case switchers: toPascalCase/toSnakeCase/toCamelCase
 */
class String
{
    ////////////////////////////////////////////////////////////////////
    ////////////////////////////// CREATE  /////////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Create a string from a number.
     *
     * <code>
     *  String::accord(0, '%d articles', '%d article', 'no articles') // Returns 'no articles'
     *  String::accord(1, '%d articles', '%d article', 'no articles') // Returns '1 article'
     *  String::accord(5, '%d articles', '%d article', 'no articles') // Returns '5 articles'
     * </code>
     *
     * @param int $count A number
     * @param string $many If many
     * @param string $one If one
     * @param string $zero If one
     *
     * @return string A string
     */
    public static function accord($count, $many, $one, $zero = null)
    {
        if ($count === 1) {
            $output = $one;
        } else {
            if ($count === 0 and !empty($zero)) {
                $output = $zero;
            } else {
                $output = $many;
            }
        }

        return sprintf($output, $count);
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * <code>
     *  String::random(10) // Returns 'anFe48cfRc'
     * </code>
     *
     * @param int $length
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    public static function random($length = 16)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length * 2);

            if ($bytes === false) {
                throw new \RuntimeException('Unable to generate random string.');
            }

            return substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $length);
        }

        return static::quickRandom($length);
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param int $length
     *
     * @return string
     */
    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * String format
     *
     * <code>
     *  String::format('Format string: {0}, {1}.', 'foo', 'bar') // Returns 'Format string: foo, bar.'
     * </code>
     *
     * @param string $string
     * @return string
     */
    public static function format($string)
    {
        $args = func_get_args();

        if (count($args) == 1) {
            return $args[0];
        }
        $str = array_shift($args);
        $pattern = '/\\{(0|[1-9]\\d*)\\}/';
        $callback = create_function('$match', '$args = ' . var_export($args, true) .
            '; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];');
        return preg_replace_callback($pattern, $callback, $str);
    }

    /**
     * Defaults to an empty string. This is not the preferred usage of
     * implode as glue would be
     * the second parameter and thus, the bad prototype would be used.
     * </p>
     * The array of strings to implode.
     * </p>
     *
     * @param string $glue
     * @param array $arr
     *
     * @return string a string containing a string representation of all the array
     * elements in the same order, with the glue string between each element.
     */
    public static function join($glue, array $arr)
    {
        return join($glue, array_filter($arr));
    }

    ////////////////////////////////////////////////////////////////////
    ////////////////////////////// ANALYZE /////////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string $haystack
     * @param string|array $needles
     *
     * @return bool
     *
     * @author Taylor Otwell
     */
    public static function startsWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    public static function endsWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ((string)$needle === substr($haystack, -strlen($needle))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a string is an IP.
     *
     * @param $string
     * @return bool
     */
    public static function isIp($string)
    {
        return filter_var($string, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * Check if a string is an email.
     *
     * @param $string
     * @return bool
     */
    public static function isEmail($string)
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Check if a string is an url.
     *
     * @param $string
     * @return bool
     */
    public static function isUrl($string)
    {
        return filter_var($string, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Check if a string is null or empty.
     *
     * @param string $string
     * @return bool
     */
    public static function isNullOrEmpty($string)
    {
        return '' === $string || is_null($string);
    }

    /**
     * Check if a string is null or empty or whitespace.
     *
     * @param string $string
     * @return bool
     */
    public static function isNullOrWhitespace($string)
    {
        return '' === trim($string) || is_null($string);
    }

    ////////////////////////////////////////////////////////////////////
    ///////////////////////////// FETCH FROM ///////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Find one or more needles in one or more haystacks.
     *
     * <code>
     *  String::find('foobar', 'oob') // Returns true
     *  String::find('foobar', array('foo', 'bar')) // Returns true
     *  String::find(array('foo', 'bar'), 'foo') // Returns true
     *  String::find('FOOBAR', 'foobar', false) // Returns false
     *  String::find('foofoo', array('foo', 'bar'), false, true) // Returns false
     * </code>
     *
     * @param array|string $haystack The haystack(s) to search in
     * @param array|string $needle The needle(s) to search for
     * @param bool $caseSensitive Whether the function is case sensitive or not
     * @param bool $absolute Whether all needle need to be found or whether one is enough
     *
     * @return bool Found or not
     */
    public static function contains($haystack, $needle, $caseSensitive = false, $absolute = false)
    {
        // If several needles
        if (is_array($needle) or is_array($haystack)) {
            if (is_array($needle)) {
                $sliceFrom = $needle;
                $sliceTo = $haystack;
            } else {
                $sliceFrom = $haystack;
                $sliceTo = $needle;
            }

            $found = 0;
            foreach ($sliceFrom as $need) {
                if (static::contains($sliceTo, $need, $absolute, $caseSensitive)) {
                    $found++;
                }
            }

            return ($absolute) ? count($sliceFrom) === $found : $found > 0;
        }

        // If not case sensitive
        if (!$caseSensitive) {
            $haystack = strtolower($haystack);
            $needle = strtolower($needle);
        }

        // If string found
        $pos = strpos($haystack, $needle);

        return !($pos === false);
    }

    /**
     * Slice a string with another string.
     *
     * <code>
     *  String::slice('foobar', 'ba') // Returns array('foo', 'bar')
     * </code>
     *
     * @param $string
     * @param $slice
     * @return array
     */
    public static function slice($string, $slice)
    {
        $sliceTo = static::sliceTo($string, $slice);
        $sliceFrom = static::sliceFrom($string, $slice);

        return [$sliceTo, $sliceFrom];
    }

    /**
     * Slice a string from a certain point.
     *
     * <code>
     *  String::sliceFrom('foobar', 'ob') // Returns 'obar'
     * </code>
     *
     * @param $string
     * @param $slice
     * @return string
     */
    public static function sliceFrom($string, $slice)
    {
        $slice = strpos($string, $slice);

        return substr($string, $slice);
    }

    /**
     * Slice a string up to a certain point.
     *
     * <code>
     *  String::sliceTo('foobar', 'ob') // Returns 'fo'
     * </code>
     *
     * @param $string
     * @param $slice
     * @return string
     */
    public static function sliceTo($string, $slice)
    {
        $slice = strpos($string, $slice);

        return substr($string, 0, $slice);
    }

    /**
     * Get the base class in a namespace.
     *
     * @param string $string
     *
     * @return string
     */
    public static function baseClass($string)
    {
        $string = static::replace($string, '\\', '/');

        return basename($string);
    }

    ////////////////////////////////////////////////////////////////////
    /////////////////////////////// ALTER //////////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Limit the number of characters in a string.
     *
     * <code>
     *  String::limit('This is somehow long', 10, '...') // Returns 'This is so...'
     * </code>
     *
     * @param string $value
     * @param int $limit
     * @param string $end
     *
     * @return string
     */
    public static function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strlen($value) <= $limit) {
            return $value;
        }

        return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
    }

    /**
     * Limit the number of words in a string.
     *
     * <code>
     *  String::words('This is somehow long', 3, '...') // Returns 'This is somehow...'
     * </code>
     *
     * @param string $value
     * @param int $words
     * @param string $end
     *
     * @return string
     *
     * @author Taylor Otwell
     */
    public static function words($value, $words = 100, $end = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $words . '}/u', $value, $matches);

        if (!isset($matches[0]) || strlen($value) === strlen($matches[0])) {
            return $value;
        }

        return rtrim($matches[0]) . $end;
    }

    /**
     * Remove part of a string.
     *
     * <code>
     *  String::remove('foo', 'oo') // Return 'f'
     *  String::remove('foo bar bis', array('bar', 'foo')) // Returns 'bis'
     * </code>
     *
     * @param $string
     * @param $remove
     * @return string
     */
    public static function remove($string, $remove)
    {
        // If we only have one string to remove
        if (!is_array($remove)) {
            $string = str_replace($remove, null, $string);
        } // Else, use Regex
        else {
            $string = preg_replace('#(' . implode('|', $remove) . ')#', null, $string);
        }

        // Trim and return
        return trim($string);
    }

    /**
     * Correct arguments order for str_replace.
     *
     * @param $string
     * @param $replace
     * @param $with
     * @return mixed
     */
    public static function replace($string, $replace, $with)
    {
        return str_replace($replace, $with, $string);
    }

    /**
     * Explode a string into an array.
     * @param $string
     * @param $with
     * @param null $limit
     * @return array
     */
    public static function split($string, $with, $limit = null)
    {
        if (!$limit) {
            return explode($with, $string);
        }

        return explode($with, $string, $limit);
    }

    /**
     * Lowercase a string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function lower($string)
    {
        return mb_strtolower($string, 'UTF-8');
    }

    /**
     * Lowercase a string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function upper($string)
    {
        return mb_strtoupper($string, 'UTF-8');
    }

    /**
     * Get the plural form of an English word.
     *
     * @param string $value
     * @return string
     */
    public static function plural($value)
    {
        return Inflector::pluralize($value);
    }

    /**
     * Get the singular form of an English word.
     *
     * @param string $value
     *
     * @return string
     */
    public static function singular($value)
    {
        return Inflector::singularize($value);
    }

    /**
     * Convert a string to title case.
     *
     * @param string $string
     *
     * @return string
     */
    public static function title($string)
    {
        return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Canonicalize a string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function canonicalize($string)
    {
        return null === $string ? null : mb_convert_case($string, MB_CASE_LOWER, mb_detect_encoding($string));
    }

    ////////////////////////////////////////////////////////////////////
    /////////////////////////// CASE SWITCHERS /////////////////////////
    ////////////////////////////////////////////////////////////////////

    /**
     * Convert a string to PascalCase.
     *
     * <code>
     *  String::toPascalCase('my_super_class') // Returns 'MySuperClass'
     *  String::toPascalCase('my_super_class', 2) // Returns 'MySuper_class'
     * </code>
     *
     * @param string $string
     *
     * @return string
     */
    public static function toPascalCase($string)
    {
        return Inflector::classify($string);
    }

    /**
     * Convert a string to snake_case.
     *
     * <code>
     *  String::toSnakeCase('MySuperClass') // Returns 'my_super_class'
     *  String::toSnakeCase('MySuperClass', 2) // Returns 'my_superClass'
     * </code>
     *
     * @param string $string
     *
     * @return string
     */
    public static function toSnakeCase($string)
    {
        return substr(preg_replace_callback('/([A-Z])/', function ($match) {
            return '_' . strtolower($match[1]);
        }, $string), 1);
    }

    /**
     * Convert a string to camelCase.
     *
     * <code>
     *  String::toCamelCase('my_super_class') // Returns 'mySuperClass'
     *  String::toCamelCase('my_super_class', 2) // Returns 'mySuper_class'
     * </code>
     *
     * @param string $string
     *
     * @return string
     */
    public static function toCamelCase($string)
    {
        return Inflector::camelize($string);
    }
}
