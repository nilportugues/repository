<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 7/01/16
 * Time: 0:15.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Order;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Sort;

/**
 * Class InMemorySort.
 */
class InMemorySorter
{
    /**
     * @param array $results
     * @param Sort  $sort
     *
     * @return array
     *
     * @throws \Exception
     */
    public static function sort(array $results, Sort $sort)
    {
        $sortOrder = array_reverse($sort->getOrders(), true);

        /** @var Order $sortDirection */
        foreach ($sortOrder as $propertyName => $sortDirection) {
            if ($sortDirection->isAscending()) {
                self::stableUasort($results, function ($a, $b) use ($propertyName) {
                    $value1 = (string)InMemoryValue::get($a, $propertyName);
                    $value2 = (string)InMemoryValue::get($b, $propertyName);

                    return ((int)(strcmp($value1, $value2) >= 0));
                });
            } else {
                self::stableUasort($results, function ($a, $b) use ($propertyName) {
                    $value1 = (string)InMemoryValue::get($a, $propertyName);
                    $value2 = (string)InMemoryValue::get($b, $propertyName);

                    return ((int)(strcmp($value1, $value2) < 0));
                });
            }
        }

        return array_values($results);
    }

    /**
     * Stable uasort function implementation to make up for unrealiable
     * implementation in PHP for both versions 5 and 7.
     *
     * @author: Clement Wong <cw@clement.hk>
     * @link  : https://bugs.php.net/bug.php?id=53341
     */
    protected static function stableUasort(array &$array, callable $cmpFunction)
    {
        if (count($array) < 2) {
            return;
        }
        $halfway = count($array) / 2;
        $array1  = array_slice($array, 0, $halfway, true);
        $array2  = array_slice($array, $halfway, null, true);

        self::stableUasort($array1, $cmpFunction);
        self::stableUasort($array2, $cmpFunction);
        if (call_user_func($cmpFunction, end($array1), reset($array2)) < 1) {
            $array = $array1 + $array2;

            return;
        }
        $array = array();
        reset($array1);
        reset($array2);
        while (current($array1) && current($array2)) {
            if (call_user_func($cmpFunction, current($array1), current($array2)) < 1) {
                $array[key($array1)] = current($array1);
                next($array1);
            } else {
                $array[key($array2)] = current($array2);
                next($array2);
            }
        }
        while (current($array1)) {
            $array[key($array1)] = current($array1);
            next($array1);
        }
        while (current($array2)) {
            $array[key($array2)] = current($array2);
            next($array2);
        }

        return;
    }
}
