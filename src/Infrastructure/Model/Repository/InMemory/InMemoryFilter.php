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

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\BaseFilter;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter;

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
            foreach ($valuePair as $property => $value) {
                if (is_array($value)) {
                    if (count($value) > 1) {
                        switch ($filterName) {
                            case BaseFilter::RANGES:
                                $filteredResults = array_merge(
                                    $filteredResults,
                                    array_filter($results, self::ranges($property, $value[0], $value[1]), ARRAY_FILTER_USE_BOTH)
                                );
                                break;
                            case BaseFilter::NOT_RANGES:
                                $filteredResults = array_merge(
                                    $filteredResults,
                                    array_filter($results, self::notRanges($property, $value[0], $value[1]), ARRAY_FILTER_USE_BOTH)
                                );
                                break;
                            case BaseFilter::GROUP:
                                $filteredResults = array_merge(
                                    $filteredResults,
                                    array_filter($results, self::in($property, $value), ARRAY_FILTER_USE_BOTH)
                                );
                                break;
                        }
                        break;
                    }
                    $value = array_shift($value);
                }

                switch ($filterName) {
                    case BaseFilter::GREATER_THAN_OR_EQUAL:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::greaterThanOrEqual($property, $value), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::GREATER_THAN:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::greaterThan($property, $value), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::LESS_THAN_OR_EQUAL:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::lessThanOrEqual($property, $value), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::LESS_THAN:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::lessThan($property, $value), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::CONTAINS:

                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::contains($property, $value), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::NOT_CONTAINS:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::notContains($property, $value), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::STARTS_WITH:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::startsWith($property, $value), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::ENDS_WITH:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::endsWith($property, $value), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::EQUALS:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::equals($property, $value), ARRAY_FILTER_USE_BOTH)
                        );
                        break;
                    case BaseFilter::NOT_EQUAL:
                        $filteredResults = array_merge(
                            $filteredResults,
                            array_filter($results, self::notEquals($property, $value), ARRAY_FILTER_USE_BOTH)
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
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function equals($property, $value)
    {
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function greaterThanOrEqual($property, $value)
    {
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function endsWith($property, $value)
    {
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function startsWith($property, $value)
    {
    }

    /**
     * @param string                $property
     * @param string|int|float|bool $needle
     *
     * @return \Closure
     */
    private static function notContains($property, $needle)
    {
        return function ($v, $k) use ($property,$needle) {
            $v = InMemoryValue::get($v, $property);

            return false === mb_strpos($v, $needle);
        };
    }

    /**
     * @param string                $property
     * @param string|int|float|bool $needle
     *
     * @return \Closure
     */
    private static function contains($property, $needle)
    {
        return function ($v, $k) use ($property,$needle) {
            $v = InMemoryValue::get($v, $property);

            return mb_strpos($v, $needle);
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
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function lessThanOrEqual($property, $value)
    {
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function greaterThan($property, $value)
    {
    }

    /**
     * @param string           $property
     * @param string|int|float $value
     *
     * @return \Closure
     */
    private static function in($property, $value)
    {
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
    }
}
