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
     * @return BaseFilterInterface
     */
    public function notEmpty(string $filterName): BaseFilterInterface
    {
        $this->notEmptyAttributes[] = $filterName;

        return $this;
    }

    /**
     * @param string $filterName
     *
     * @return BaseFilterInterface
     */
    public function hasEmpty(string $filterName): BaseFilterInterface
    {
        $this->emptyAttributes[] = $filterName;

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function startsWith(string $filterName, $value) : BaseFilterInterface
    {
        $this->addFilter(self::STARTS_WITH, $filterName, $value);

        return $this;
    }

    /**
     * @param string $property
     * @param string $filterName
     * @param mixed  $value
     */
    protected function addFilter(string $property, string $filterName, $value)
    {
        $filterName = (string) $filterName;
        $property = (string) $property;

        $this->filters[$property][$filterName][] = $value;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function endsWith(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::ENDS_WITH, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function equal(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::EQUALS, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function notEqual(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::NOT_EQUAL, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function includeGroup(string $filterName, array $value): BaseFilterInterface
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
     * @return BaseFilterInterface
     */
    public function notIncludeGroup(string $filterName, array $value): BaseFilterInterface
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
     * @return BaseFilterInterface
     */
    public function range(string $filterName, $firstValue, $secondValue): BaseFilterInterface
    {
        $this->addFilter(self::RANGES, $filterName, [$firstValue, $secondValue]);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $firstValue
     * @param mixed  $secondValue
     *
     * @return BaseFilterInterface
     */
    public function notRange(string $filterName, $firstValue, $secondValue): BaseFilterInterface
    {
        $this->addFilter(self::NOT_RANGES, $filterName, [$firstValue, $secondValue]);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function notContain(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::NOT_CONTAINS, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function contain(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::CONTAINS, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function beGreaterThanOrEqual(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::GREATER_THAN_OR_EQUAL, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function beGreaterThan(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::GREATER_THAN, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function beLessThanOrEqual(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::LESS_THAN_OR_EQUAL, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     * @param mixed  $value
     *
     * @return BaseFilterInterface
     */
    public function beLessThan(string $filterName, $value) : BaseFilterInterface
    {
        $this->addFilter(self::LESS_THAN, $filterName, $value);

        return $this;
    }

    /**
     * @return BaseFilterInterface
     */
    public function clear(): BaseFilterInterface
    {
        $this->filters = [];
        $this->emptyAttributes = [];
        $this->notEmptyAttributes = [];

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $filters = array_merge(
            $this->filters,
            ['be_empty' => $this->emptyAttributes, 'be_not_empty' => $this->notEmptyAttributes]
        );

        return $filters;
    }

    /**
     * @param string $filterName
     *
     * @param $value
     * @return BaseFilterInterface
     */
    public function notStartsWith(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::NOT_STARTS, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     *
     * @param $value
     * @return BaseFilterInterface
     */
    public function notEndsWith(string $filterName, $value): BaseFilterInterface
    {
        $this->addFilter(self::NOT_ENDS, $filterName, $value);

        return $this;
    }

    /**
     * @param string $filterName
     *
     * @return BaseFilterInterface
     */
    public function empty(string $filterName): BaseFilterInterface
    {
        return $this->hasEmpty($filterName);
    }
}
