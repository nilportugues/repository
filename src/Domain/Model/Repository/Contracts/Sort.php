<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/01/16
 * Time: 18:37.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository\Contracts;

interface Sort
{
    /**
     * Creates a new Sort instance using the given Order.
     *
     * @param array $properties
     * @param Order $order
     */
    public function __construct(array $properties = [], Order $order = null);

    /**
     * Returns a new Sort consisting of the orders of the current Sort combined with the given ones.
     *
     * @param Sort $sort
     *
     * @return Sort
     */
    public function andSort(Sort $sort);

    /**
     * @return Order[]
     */
    public function orders();

    /**
     * @param Sort $sort
     *
     * @return bool
     */
    public function equals(Sort $sort);

    /**
     * Returns the order registered for the given property.
     *
     * @param string $propertyName
     *
     * @return Order
     */
    public function orderFor($propertyName);

    /**
     * @param string $propertyName
     * @param Order  $order
     */
    public function setOrderFor($propertyName, Order $order);

    /**
     * @param string $propertyName
     *
     * @return Order
     *
     * @throws \InvalidArgumentException
     */
    public function property($propertyName);
}
