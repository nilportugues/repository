<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/01/16
 * Time: 18:25.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository\Contracts;

interface Order
{
    const ASCENDING = 'ASC';
    const DESCENDING = 'DESC';

    /**
     * @return bool
     */
    public function isDescending();

    /**
     * @return bool
     */
    public function isAscending();

    /**
     * @return string
     */
    public function getDirection();

    /**
     * @return string
     */
    public function __toString();

    /**
     * Compares the current object with a second object.
     * It will compare its type and and its properties values.
     *
     * @param self $object
     *
     * @return bool
     */
    public function equals($object);
}
