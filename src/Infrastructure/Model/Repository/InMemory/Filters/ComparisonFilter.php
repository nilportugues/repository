<?php

namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\Filters;

use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\PropertyValue;

class ComparisonFilter
{
    /**
     * @param string $property
     * @return \Closure
     */
    public static function empty(string $property): \Closure
    {
        return function ($v) use ($property) {
            return PropertyValue::get($v, $property) === null || PropertyValue::get($v, $property) === '';
        };
    }

    /**
     * @param string $property
     * @return \Closure
     */
    public static function notEmpty(string $property): \Closure
    {
        return function ($v) use ($property) {
            return PropertyValue::get($v, $property) !== null && PropertyValue::get($v, $property) !== '';
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    public static function equals(string $property, $value): \Closure
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
    public static function notEquals(string $property, $value): \Closure
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
    public static function greaterThanOrEqual(string $property, $value): \Closure
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
    public static function greaterThan(string $property, $value): \Closure
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
    public static function lessThanOrEqual(string $property, $value): \Closure
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
    public static function lessThan(string $property, $value): \Closure
    {
        return function ($v) use ($property, $value) {
            return PropertyValue::get($v, $property) < $value;
        };
    }
}
