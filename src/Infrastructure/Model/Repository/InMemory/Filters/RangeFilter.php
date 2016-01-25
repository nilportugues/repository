<?php

namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\Filters;

use Exception;
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\InMemoryValue;

class RangeFilter
{
    /**
     * @param string           $property
     * @param string|int|float $value1
     * @param string|int|float $value2
     *
     * @return \Closure
     */
    public static function ranges($property, $value1, $value2)
    {
        return function ($v) use ($property, $value1, $value2) {
            $v = InMemoryValue::get($v, $property);
            self::sameTypeGuard($v, $value1, $value2);

            return $v >= $value1 && $v <= $value2;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value1
     * @param string|int|float $value2
     *
     * @return \Closure
     */
    public static function notRanges($property, $value1, $value2)
    {
        return function ($v) use ($property, $value1, $value2) {
            $v = InMemoryValue::get($v, $property);
            self::sameTypeGuard($v, $value1, $value2);

            return !($v >= $value1 && $v <= $value2);
        };
    }

    /**
     * @param $v
     * @param $value1
     * @param $value2
     *
     * @throws Exception
     */
    private static function sameTypeGuard($v, $value1, $value2)
    {
        if (1 !== count(array_unique($types = [is_scalar($value1), is_scalar($value2), is_scalar($v)]))) {
            throw new Exception('Range values and property values should be of the same type, either scalars or objects.');
        }
    }
}
