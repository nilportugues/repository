<?php

namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\Filters;

use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\InMemoryValue;
use Traversable;

class ContainenceFilter
{
    /**
     * @param string                $property
     * @param string|int|float|bool $value
     *
     * @return \Closure
     */
    public static function contains($property, $value)
    {
        return function ($v) use ($property, $value) {
            $v = InMemoryValue::get($v, $property);

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
    public static function notContains($property, $value)
    {
        return function ($v) use ($property, $value) {
            $v = InMemoryValue::get($v, $property);

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
    public static function in($property, array $value)
    {
        return function ($v) use ($property, $value) {
            $hasGroup = true;
            $v = InMemoryValue::get($v, $property);

            foreach ($value as $groupItem) {
                if (is_scalar($v)) {
                    $hasGroup = $hasGroup && 1 == preg_match(sprintf('/%s/i', $groupItem), $v);
                }

                if (is_array($v)) {
                    $hasGroup = $hasGroup && in_array($groupItem, $v);
                }
            }

            return $hasGroup;
        };
    }

    /**
     * @param string $property
     * @param array  $value
     *
     * @return \Closure
     */
    public static function notIn($property, array $value)
    {
        return function ($v) use ($property, $value) {
            $hasGroup = true;
            $v = InMemoryValue::get($v, $property);

            foreach ($value as $groupItem) {
                if (is_scalar($v)) {
                    $hasGroup = $hasGroup && 1 == preg_match(sprintf('/%s/i', $groupItem), $v);
                }

                if (is_array($v)) {
                    $hasGroup = $hasGroup && in_array($groupItem, $v);
                }
            }

            return !$hasGroup;
        };
    }
}
