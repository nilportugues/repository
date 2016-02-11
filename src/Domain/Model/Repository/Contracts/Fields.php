<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 10/01/16
 * Time: 18:13.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository\Contracts;

interface Fields
{
    /**
     * Fields constructor.
     *
     * @param array $fields
     */
    public function __construct(array $fields = []);

    /**
     * @param string $field
     */
    public function add($field);

    /**
     * @return array
     */
    public function get();

    /**
     * Creates a null Value Object.
     *
     * @return self
     */
    public static function null();

    /**
     * @return bool
     */
    public function isNull();
}
