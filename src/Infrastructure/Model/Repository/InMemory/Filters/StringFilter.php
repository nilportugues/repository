<?php

namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\Filters;

use Exception;
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\InMemoryValue;

class StringFilter
{
    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    public static function startsWith($property, $value)
    {
        return function ($v) use ($property, $value) {
            $v = InMemoryValue::get($v, $property);

            self::propertyGuard($v, $property);
            self::valueGuard($value, 'Starting');

            return 1 == preg_match(sprintf('/^%s/i', $value), $v);
        };
    }

    /**
     * @param $v
     * @param $property
     *
     * @throws Exception
     */
    private static function propertyGuard($v, $property)
    {
        if (false === is_scalar($v)) {
            throw new Exception(sprintf("Value for '%s' is not a scalar value.", $property));
        }
    }

    /**
     * @param $value
     * @param $type
     *
     * @throws Exception
     */
    private static function valueGuard($value, $type)
    {
        if (false === is_scalar($value)) {
            throw new Exception(sprintf('%s value provided is not a scalar value.', $type));
        }
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    public static function endsWith($property, $value)
    {
        return function ($v) use ($property, $value) {
            $v = InMemoryValue::get($v, $property);

            self::propertyGuard($v, $property);
            self::valueGuard($value, 'Ending');

            return 1 == preg_match(sprintf('/%s$/i', $value), $v);
        };
    }

    /**
     * @param $property
     * @param $value
     *
     * @return \Closure
     */
    public static function notStartsWith($property, $value)
    {
        return function ($v) use ($property, $value) {
            $v = InMemoryValue::get($v, $property);

            self::propertyGuard($v, $property);
            self::valueGuard($value, 'Starting');

            return 0 == preg_match(sprintf('/^%s/i', $value), $v);
        };
    }

    /**
     * @param $property
     * @param $value
     *
     * @return \Closure
     */
    public static function notEndsWith($property, $value)
    {
        return function ($v) use ($property, $value) {
            $v = InMemoryValue::get($v, $property);

            self::propertyGuard($v, $property);
            self::valueGuard($value, 'Ending');

            return 0 == preg_match(sprintf('/%s$/i', $value), $v);
        };
    }
}
