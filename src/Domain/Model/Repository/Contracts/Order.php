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
    public function isDescending(): bool;

    /**
     * @return bool
     */
    public function isAscending(): bool;

    /**
     * @return string
     */
    public function direction(): string;

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * Compares the current object with a second object.
     * It will compare its type and and its properties values.
     *
     * @param Order $object
     *
     * @return bool
     */
    public function equals(Order $object): bool;

    /**
     * Creates a null Value Object.
     *
     * @return self
     */
    public static function null();

    /**
     * @return bool
     */
    public function isNull(): bool;
}
