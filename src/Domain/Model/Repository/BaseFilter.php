<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/19/15
 * Time: 5:59 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\BaseFilter as BaseFilterInterface;

class BaseFilter implements BaseFilterInterface
{
    /**
     * @var array
     */
    protected $filters;
    /**
     * @var array
     */
    protected $emptyAttributes;
    /**
     * @var array
     */
    protected $notEmptyAttributes;

    /**
     *
     */
    public function __construct()
    {
        $this->filters = [];
        $this->emptyAttributes = [];
        $this->notEmptyAttributes = [];
    }

    /**
     * @param string $filterName
     *
     * @return $this
     */
    public function notEmpty($filterName)
    {
        $this->notEmptyAttributes[] = $filterName;

        return $this;
    }

    /**
     * @param string $filterName
     *
     * @return $this
     */
    public function hasEmpty($filterName)
    {
        $this->emptyAttributes[] = $filterName;

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function startsWith($filterName, $value)
    {
        $this->addFilter(self::STARTS_WITH, $filterName, $value);

        return $this;
    }

    /**
     * @param string $property
     * @param string $filterName
     * @param mixed  $value
     */
    protected function addFilter($property, $filterName, $value)
    {
        $filterName = (string) $filterName;
        $property = (string) $property;

        $this->filters[$property][$filterName][] = $value;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function endsWith($filterName, $value)
    {
        $this->addFilter(self::ENDS_WITH, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function equals($filterName, $value)
    {
        $this->addFilter(self::EQUALS, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function notEquals($filterName, $value)
    {
        $this->addFilter(self::NOT_EQUAL, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function includesGroup($filterName, array $value)
    {
        $filterName = (string) $filterName;

        $this->filters[self::GROUP][$filterName] = array_merge(
            (!empty($this->filters[self::GROUP][$filterName])) ? $this->filters[self::GROUP][$filterName] : [],
            array_values($value)
        );

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function notIncludesGroup($filterName, array $value)
    {
        $filterName = (string) $filterName;

        $this->filters[self::NOT_GROUP][$filterName] = array_merge(
            (!empty($this->filters[self::NOT_GROUP][$filterName])) ? $this->filters[self::NOT_GROUP][$filterName] : [],
            array_values($value)
        );

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $firstValue
     * @param mixed  $secondValue
     *
     * @return $this
     */
    public function ranges($filterName, $firstValue, $secondValue)
    {
        $this->addFilter(self::RANGES, $filterName, [$firstValue, $secondValue]);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $firstValue
     * @param mixed  $secondValue
     *
     * @return $this
     */
    public function notRanges($filterName, $firstValue, $secondValue)
    {
        $this->addFilter(self::NOT_RANGES, $filterName, [$firstValue, $secondValue]);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function notContains($filterName, $value)
    {
        $this->addFilter(self::NOT_CONTAINS, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function contains($filterName, $value)
    {
        $this->addFilter(self::CONTAINS, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function greaterThanOrEqual($filterName, $value)
    {
        $this->addFilter(self::GREATER_THAN_OR_EQUAL, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function greaterThan($filterName, $value)
    {
        $this->addFilter(self::GREATER_THAN, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function lessThanOrEqual($filterName, $value)
    {
        $this->addFilter(self::LESS_THAN_OR_EQUAL, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function lessThan($filterName, $value)
    {
        $this->addFilter(self::LESS_THAN, $filterName, $value);

        return $this;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->filters = [];
        $this->emptyAttributes = [];
        $this->notEmptyAttributes = [];

        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        $filters = array_merge(
            $this->filters,
            ['be_empty' => $this->emptyAttributes, 'be_not_empty' => $this->notEmptyAttributes]
        );

        return $filters;
    }
}
