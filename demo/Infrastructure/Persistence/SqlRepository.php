<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/21/15
 * Time: 2:05 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Demo\Infrastructure\Persistence;

use PhpDdd\Foundation\Domain\Repository\BaseFilter;
use PhpDdd\Foundation\Domain\Repository\Filter;
use PhpDdd\Foundation\Domain\Repository\Sort;

abstract class SqlRepository
{
    /**
     * @var array
     */
    private $operatorMap = [
        BaseFilter::GREATER_THAN_OR_EQUAL => '%s >= %s',
        BaseFilter::GREATER_THAN          => '%s > %s',
        BaseFilter::LESS_THAN_OR_EQUAL    => '%s <= %s',
        BaseFilter::LESS_THAN             => '%s < %s',
        BaseFilter::CONTAINS              => '%s LIKE %s',
        BaseFilter::STARTS_WITH           => '%s LIKE %s',
        BaseFilter::ENDS_WITH             => '%s LIKE %s',
        BaseFilter::NOT_CONTAINS          => '%s NOT IN(%s)',
        BaseFilter::RANGES                => '%s BETWEEN %s AND %s',
        BaseFilter::GROUP                 => '%s IN(%s)',
        BaseFilter::EQUALS                => '%s = %s',
        BaseFilter::NOT_EQUAL             => '%s != %s',
    ];

    /**
     * @var array
     */
    private $filterOptions = [
        'must'     => 'AND',
        'must_not' => 'AND NOT',
        'should'   => 'OR'
    ];

    /**
     * Reads the $filter property and returns an SQL string.
     *
     * @param Filter $filter
     *
     * @return array
     */
    protected function filtersToSql(Filter $filter = null)
    {
        $sql      = [];
        $bindings = [];

        if (null !== $filter) {
            foreach ($filter->filters() as $filterOption => $conditions) {
                foreach ($conditions as $operator => $property) {
                    $this->buildConditionQueries($property, $sql, $bindings, $operator, $filterOption);
                }
            }
        }

        return [$this->buildWhereStatement($sql), $bindings];
    }

    /**
     * @param array  $property
     * @param array  $sql
     * @param array  $bindings
     * @param string $operator
     * @param string $filterOption
     */
    private function buildConditionQueries(array &$property, array &$sql, array &$bindings, $operator, $filterOption)
    {
        foreach ($property as $propertyName => $propertyValues) {
            $diff = $this->setConditionBindings($bindings, $propertyValues);

            $sql[$filterOption][] = vsprintf(
                $this->operatorMap[$operator],
                array_merge([$propertyName], $this->getConditionPlaceholders(array_slice($bindings, $diff)))
            );
        }
    }

    /**
     * @param array $bindings
     * @param array $propertyValues
     *
     * @return int
     */
    private function setConditionBindings(array &$bindings, array &$propertyValues)
    {
        $diff = 0;
        foreach ($propertyValues as $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $bindings[$this->nextKey($bindings)] = $v;
                    ++$diff;
                }
            } else {
                $bindings[$this->nextKey($bindings)] = $value;
                ++$diff;
            }
        }
        return ($diff>0) ? $diff -1 : 0;
    }

    /**
     * @param array $bindings
     *
     * @return string
     */
    private function nextKey(array &$bindings)
    {
        return sprintf(':v%s', count($bindings)+1);
    }

    /**
     * @param array $newBindings
     *
     * @return string
     */
    private function getConditionPlaceholders(array &$newBindings)
    {
        return array_keys($newBindings);
    }

    /**
     * Flattens the array containing the filterable data into a SQL WHERE statement.
     *
     * @param array $sql
     *
     * @return string
     */
    private function buildWhereStatement(array &$sql)
    {
        foreach ($sql as $option => $conditions) {
            $sql[$option] = implode(" " . $this->filterOptions[$option] . " ", $sql[$option]);
        }

        $sql = implode(" ", $sql);

        return (false === empty($sql)) ? ' WHERE ' . $sql : '';
    }

    /**
     * Reads the $sort property and returns an SQL string.
     *
     * @param Sort $sort
     *
     * @return string
     */
    protected function sortToSql(Sort $sort = null)
    {
        $sqlOrder = '';

        if (null !== $sort) {
            $sqlOrder = [];
            foreach ($sort->getProperties() as $propertyName => $order) {
                /** @var \PhpDdd\Foundation\Domain\Repository\Order $order */
                $order      = (true === $order->isAscending()) ? 'ASC' : 'DESC';
                $sqlOrder[] = sprintf('%s %s', $propertyName, $order);
            }

            $sqlOrder = implode(', ', $sqlOrder);
            $sqlOrder = (false === empty($sqlOrder)) ? ' ORDER BY ' . $sqlOrder : '';
        }

        return $sqlOrder;
    }
}
