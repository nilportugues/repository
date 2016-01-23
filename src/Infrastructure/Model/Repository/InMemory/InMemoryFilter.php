<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 20/01/16
 * Time: 23:55.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory;

use Exception;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\BaseFilter;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter;
use Traversable;

/**
 * Class InMemoryFilter.
 */
class InMemoryFilter
{
    const MUST_NOT = 'must_not';
    const MUST = 'must';
    const SHOULD = 'should';

    /**
     * @param array  $results
     * @param Filter $filter
     *
     * @return array
     */
    public static function filter(array $results, Filter $filter)
    {
        $filteredResults = [];

        foreach ($filter->filters() as $condition => $filters) {
            switch ($condition) {
                case self::MUST:
                    self::must($results, $filteredResults, $filters);
                    break;

                case self::MUST_NOT:
                    self::mustNot($results, $filteredResults, $filters);
                    break;

                case self::SHOULD:
                    self::should($results, $filteredResults, $filters);
                    break;
            }
        }

        return $filteredResults;
    }

    /**
     * @param array $results
     * @param array $filteredResults
     * @param array $filters
     */
    protected static function must(array &$results, array &$filteredResults, array $filters)
    {
        foreach ($filters as $filterName => $valuePair) {
            foreach ($valuePair as $property => $v) {
                if (is_array($v)) {
                    if (count($v[0]) > 1) {
                        switch ($filterName) {
                            case BaseFilter::RANGES:
                                $filteredResults = array_merge(
                                    $filteredResults,
                                    array_filter($results, self::ranges($property, $v[0][0], $v[0][1]),
                                        ARRAY_FILTER_USE_BOTH)
                                );
                                break;
                            case BaseFilter::NOT_RANGES:
                                $filteredResults = array_merge(
                                    $filteredResults,
                                    array_filter($results, self::notRanges($property, $v[0][0], $v[0][1]),
                                        ARRAY_FILTER_USE_BOTH)
                                );
                                break;

                        }
                        continue;
                    }
                }
                switch ($filterName) {
                    case BaseFilter::GROUP:

                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::in($property, $v), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::GREATER_THAN_OR_EQUAL:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::greaterThanOrEqual($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::GREATER_THAN:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::greaterThan($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::LESS_THAN_OR_EQUAL:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::lessThanOrEqual($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::LESS_THAN:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::lessThan($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::CONTAINS:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::contains($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::NOT_CONTAINS:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::notContains($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::STARTS_WITH:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::startsWith($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::ENDS_WITH:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::endsWith($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::EQUALS:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::equals($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::NOT_EQUAL:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::notEquals($property, $v[0]), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                }
            }
        }
    }

    /**
     * @param array $results
     * @param array $filteredResults
     * @param array $filters
     */
    protected static function mustNot(array &$results, array &$filteredResults, array $filters)
    {
    }

    /**
     * @param array $results
     * @param array $filteredResults
     * @param array $filters
     */
    protected static function should(array &$results, array &$filteredResults, array $filters)
    {
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function notEquals($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
            return InMemoryValue::get($v, $property) != $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function equals($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
            return InMemoryValue::get($v, $property) == $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function greaterThanOrEqual($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
            return InMemoryValue::get($v, $property) >= $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function endsWith($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
            $v = InMemoryValue::get($v, $property);

            if (false === is_scalar($v)) {
                throw new Exception(sprintf("Value for '%s' is not a scalar value.", $property));
            }

            if (false === is_scalar($value)) {
                throw new Exception("Ending value provided is not a scalar value.");
            }

            return 1 == preg_match(sprintf('/%s$/i', $value), $v);
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function startsWith($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
            $v = InMemoryValue::get($v, $property);

            if (false === is_scalar($v)) {
                throw new Exception(sprintf("Value for '%s' is not a scalar value.", $property));
            }

            if (false === is_scalar($value)) {
                throw new Exception("Starting value provided is not a scalar value.");
            }

            return 1 == preg_match(sprintf('/^%s/i', $value), $v);
        };
    }

    /**
     * @param string                $property
     * @param string|int|float|bool $value
     *
     * @return \Closure
     */
    private static function notContains($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
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
     * @param string                $property
     * @param string|int|float|bool $value
     *
     * @return \Closure
     */
    private static function contains($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
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
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function lessThan($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
            return InMemoryValue::get($v, $property) < $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function lessThanOrEqual($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
            return InMemoryValue::get($v, $property) <= $value;
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function greaterThan($property, $value)
    {
        return function ($v, $k) use ($property, $value) {
            return InMemoryValue::get($v, $property) > $value;
        };
    }

    /**
     * @param string $property
     * @param array  $value
     *
     * @return \Closure
     */
    private static function in($property, array $value)
    {
        return function ($v, $k) use ($property, $value) {
            $hasGroup = true;
            $v        = InMemoryValue::get($v, $property);

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
     * @param string           $property
     * @param string|int|float $value1
     * @param string|int|float $value2
     *
     * @return \Closure
     */
    private static function notRanges($property, $value1, $value2)
    {
        return function ($v, $k) use ($property, $value1, $value2) {
            $v = InMemoryValue::get($v, $property);

            //@todo check if $v is of "type" and $value1 or $value2 are of the same "type" to... (is_object, is_scalar)

            return !($v >= $value1 && $v <= $value2);
        };
    }

    /**
     * @param string           $property
     * @param string|int|float $value1
     * @param string|int|float $value2
     *
     * @return \Closure
     */
    private static function ranges($property, $value1, $value2)
    {
        return function ($v, $k) use ($property, $value1, $value2) {
            $v = InMemoryValue::get($v, $property);

            //@todo check if $v is of "type" and $value1 or $value2 are of the same "type" to... (is_object, is_scalar)

            return $v >= $value1 && $v <= $value2;
        };
    }
}
