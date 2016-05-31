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

interface Pageable
{
    /**
     * Pageable constructor.
     *
     * @param             $pageNumber
     * @param             $pageSize
     * @param Sort|null   $sort
     * @param Filter|null $filter
     * @param Fields|null $fields
     * @param Fields|null $distinctFields
     */
    public function __construct(
        $pageNumber,
        $pageSize,
        Sort $sort = null,
        Filter $filter = null,
        Fields $fields = null,
        Fields $distinctFields = null
    );

    /**
     * @return int
     */
    public function offset(): int;

    /**
     * @return int
     */
    public function pageNumber(): int;

    /**
     * @return Sort
     */
    public function sortings(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Sort;

    /**
     * @return Pageable
     */
    public function next(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable;

    /**
     * @return int
     */
    public function pageSize(): int;

    /**
     * @return Pageable
     */
    public function previousOrFirst(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable;

    /**
     * @return bool
     */
    public function hasPrevious(): bool;

    /**
     * @return Pageable
     */
    public function first(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable;

    /**
     * @return Filter
     */
    public function filters(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter;

    /**
     * @return Fields
     */
    public function fields(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Fields;

    /**
     * @return Fields
     */
    public function distinctFields(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Fields;
}
