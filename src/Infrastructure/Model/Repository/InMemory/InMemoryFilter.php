<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 20/01/16
 * Time: 23:55
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\BaseFilter;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter;

/**
 * Class InMemoryFilter
 * @package NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory
 */
class InMemoryFilter
{
    const MUST_NOT = 'must_not';
    const MUST = 'must';
    const SHOULD = 'should';


    /**
     * @param array  $results
     * @param Filter $filter
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
}