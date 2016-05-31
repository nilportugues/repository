<?php

namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\Filters;

use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\PropertyValue;
use Traversable;

class ContainenceFilter
{
    /**
     * @param string                $property
     * @param string|int|float|bool $value
     *
     * @return \Closure
     */
    public static function contains(string $property, $value): \Closure
    {
        return function ($v) use ($property, $value) {
            $v = PropertyValue::get($v, $property);

            if (is_scalar($v)) {
                return 1 == preg_match(sprintf('/%s/i', $value), $v);
            }

            if (is_array($v)) {
                return in_array($value, $v);
            }

            $contains = false;
            if ($v instanceof Traversable) {
                foreach ($v as $item) {
                    return ($value == $item);
                }
            }

            return $contains;
        };
    }

    /**
     * @param string                $property
     * @param string|int|float|bool $value
     *
     * @return \Closure
     */
    public static function notContains(string $property, $value): \Closure
    {
        return function ($v) use ($property, $value) {
            $v = PropertyValue::get($v, $property);

            if (is_scalar($v)) {
                return 0 == preg_match(sprintf('/%s/i', $value), $v);
            }

            if (is_array($v)) {
                return false === in_array($value, $v);
            }

            $contains = false;
            if ($v instanceof Traversable) {
                foreach ($v as $item) {
                    $contains = ($value == $item);
                }
                $contains = !$contains;
            }

            return $contains;
        };
    }

    /**
     * @param string $property
     * @param array  $value
     *
     * @return \Closure
     */
    public static function in(string $property, array $value): \Closure
    {
        return function ($v) use ($property, $value) {
            $v = PropertyValue::get($v, $property);

            $isTrue = [];
            foreach ($value as $groupItem) {
                if (is_scalar($v)) {
                    $isTrue[] = 1 == preg_match(sprintf('/%s/i', $groupItem), $v);
                }

                if (is_array($v)) {
                    $isTrue[] = in_array($groupItem, $v, false);
                }

                if (is_object($v)) {
                    $isTrue[] = ($groupItem == $v);
                }
            }
            $isTrue = array_unique($isTrue);

            return false !== array_search(true, $isTrue, false);
        };
    }

    /**
     * @param string $property
     * @param array  $value
     *
     * @return \Closure
     */
    public static function notIn(string $property, array $value): \Closure
    {
        return function ($v) use ($property, $value) {
            $hasGroup = true;
            $v = PropertyValue::get($v, $property);

            foreach ($value as $groupItem) {
                if (is_scalar($v)) {
                    $hasGroup = $hasGroup && 0 == preg_match(sprintf('/^%s/i', $groupItem), $v);
                }

                if (is_array($v)) {
                    $hasGroup = $hasGroup && false === array_search($groupItem, $v, false);
                }

                if (is_object($v)) {
                    $hasGroup = $hasGroup && ($groupItem != $v);
                }
            }

            return $hasGroup;
        };
    }
}
