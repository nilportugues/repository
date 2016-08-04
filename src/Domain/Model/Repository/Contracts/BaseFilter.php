<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/01/16
 * Time: 18:40.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository\Contracts;

interface BaseFilter
{
    const GREATER_THAN_OR_EQUAL = 'gte';
    const GREATER_THAN = 'gt';
    const LESS_THAN_OR_EQUAL = 'lte';
    const LESS_THAN = 'lt';
    const CONTAINS = 'contains';
    const STARTS_WITH = 'start_with';
    const ENDS_WITH = 'end_with';
    const NOT_CONTAINS = 'not_contains';
    const RANGES = 'ranges';
    const NOT_RANGES = 'not_ranges';
    const GROUP = 'group';
    const NOT_GROUP = 'not_group';
    const EQUALS = 'equals';
    const NOT_EQUAL = 'not_equals';
    const EMPTY = 'empty';
    const NOT_EMPTY = 'not_empty';
    const NOT_ENDS = 'not_ends';
    const NOT_STARTS = 'not_starts';


    /**
     * @param string $filterName
     * @param $value
     * @return BaseFilter
     */
    public function notStartsWith(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     * @return BaseFilter
     */
    public function notEndsWith(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     *
     * @return BaseFilter
     */
    public function empty(string $filterName): BaseFilter;

    /**
     * @param string $filterName
     *
     * @return BaseFilter
     */
    public function notEmpty(string $filterName): BaseFilter;

    /**
     * @param string $filterName
     *
     * @return BaseFilter
     */
    public function hasEmpty(string $filterName): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function startsWith(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function endsWith(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function equal(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function notEqual(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param array  $value
     *
     * @return BaseFilter
     */
    public function includeGroup(string $filterName, array $value): BaseFilter;

    /**
     * @param string $filterName
     * @param array  $value
     *
     * @return BaseFilter
     */
    public function notIncludeGroup(string $filterName, array $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $firstValue
     * @param $secondValue
     *
     * @return BaseFilter
     */
    public function range(string $filterName, $firstValue, $secondValue): BaseFilter;

    /**
     * @param string $filterName
     * @param $firstValue
     * @param $secondValue
     *
     * @return BaseFilter
     */
    public function notRange(string $filterName, $firstValue, $secondValue): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function notContain(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function contain(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function beGreaterThanOrEqual(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function beGreaterThan(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function beLessThanOrEqual(string $filterName, $value): BaseFilter;

    /**
     * @param string $filterName
     * @param $value
     *
     * @return BaseFilter
     */
    public function beLessThan(string $filterName, $value): BaseFilter;

    /**
     * @return mixed
     */
    public function clear();

    /**
     * @return mixed
     */
    public function get() : array;
}
