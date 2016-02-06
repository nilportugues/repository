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

    /**
     * @param $filterName
     *
     * @return mixed
     */
    public function notEmpty($filterName);

    /**
     * @param $filterName
     *
     * @return mixed
     */
    public function hasEmpty($filterName);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function startsWith($filterName, $value);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function endsWith($filterName, $value);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function equals($filterName, $value);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function notEquals($filterName, $value);

    /**
     * @param       $filterName
     * @param array $value
     *
     * @return mixed
     */
    public function includesGroup($filterName, array $value);

    /**
     * @param       $filterName
     * @param array $value
     *
     * @return mixed
     */
    public function notIncludesGroup($filterName, array $value);

    /**
     * @return $this
     */
    public function ranges($filterName, $firstValue, $secondValue);

    /**
     * @param $filterName
     * @param $firstValue
     * @param $secondValue
     *
     * @return mixed
     */
    public function notRanges($filterName, $firstValue, $secondValue);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function notContains($filterName, $value);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function contains($filterName, $value);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function greaterThanOrEqual($filterName, $value);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function greaterThan($filterName, $value);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function lessThanOrEqual($filterName, $value);

    /**
     * @param $filterName
     * @param $value
     *
     * @return mixed
     */
    public function lessThan($filterName, $value);

    /**
     * @return mixed
     */
    public function clear();

    /**
     * @return mixed
     */
    public function get();
}
