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
    const EQUALS = 'equals';
    const NOT_EQUAL = 'not_equals';

    /**
     * @return $this
     */
    public function notEmpty($filterName);

    /**
     * @return $this
     */
    public function hasEmpty($filterName);

    /**
     * @return $this
     */
    public function startsWith($filterName, $value);

    /**
     * @return $this
     */
    public function endsWith($filterName, $value);

    /**
     * @return $this
     */
    public function equals($filterName, $value);

    /**
     * @return $this
     */
    public function notEquals($filterName, $value);

    /**
     * @return $this
     */
    public function includesGroup($filterName, array $value);

    /**
     * @return $this
     */
    public function ranges($filterName, $firstValue, $secondValue);

    /**
     * @return $this
     */
    public function notRanges($filterName, $firstValue, $secondValue);

    /**
     * @return $this
     */
    public function notContains($filterName, $value);

    /**
     * @return $this
     */
    public function contains($filterName, $value);

    /**
     * @return $this
     */
    public function greaterThanOrEqual($filterName, $value);

    /**
     * @return $this
     */
    public function greaterThan($filterName, $value);

    /**
     * @return $this
     */
    public function lessThanOrEqual($filterName, $value);

    /**
     * @return $this
     */
    public function lessThan($filterName, $value);

    /**
     * @return $this
     */
    public function clear();

    /**
     * @return array
     */
    public function get();
}
