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

interface Filter
{
    const MUST = 0;
    const MUST_NOT = 1;
    const SHOULD = 2;

    /**
     * @return array
     */
    public function filters(): array;

    /**
     * @return BaseFilter
     */
    public function must(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\BaseFilter;

    /**
     * @return BaseFilter
     */
    public function mustNot(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\BaseFilter;

    /**
     * @return BaseFilter
     */
    public function should(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\BaseFilter;

    /**
     * @return $this
     */
    public function clear();

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
