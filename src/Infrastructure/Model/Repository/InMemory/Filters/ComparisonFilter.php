<?php

namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\Filters;

use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\PropertyValue;

class ComparisonFilter
{
    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    public static function equals($property, $value)
    {
        return function ($v) use ($property, $value) {
            return PropertyValue::get($v, $property) == $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    public static function notEquals($property, $value)
    {
        return function ($v) use ($property, $value) {
            return PropertyValue::get($v, $property) != $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    public static function greaterThanOrEqual($property, $value)
    {
        return function ($v) use ($property, $value) {
            return PropertyValue::get($v, $property) >= $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    public static function greaterThan($property, $value)
    {
        return function ($v) use ($property, $value) {
            return PropertyValue::get($v, $property) > $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    public static function lessThanOrEqual($property, $value)
    {
        return function ($v) use ($property, $value) {
            return PropertyValue::get($v, $property) <= $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    public static function lessThan($property, $value)
    {
        return function ($v) use ($property, $value) {
            return PropertyValue::get($v, $property) < $value;
        };
    }
}
