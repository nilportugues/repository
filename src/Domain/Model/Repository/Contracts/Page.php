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

interface Page
{
    /**
     * Page constructor.
     *
     * @param array  $elements
     * @param        $totalElements
     * @param        $pageNumber
     * @param        $totalPages
     * @param Sort   $sort
     * @param Filter $filter
     * @param Fields $fields
     */
    public function __construct(
        array $elements,
        $totalElements,
        $pageNumber,
        $totalPages,
        Sort $sort = null,
        Filter $filter = null,
        Fields $fields = null
    );

    /**
     * Returns the page content as an array.
     *
     * @return array
     */
    public function content(): array;

    /**
     * Returns if there is a previous Page.
     *
     * @return bool
     */
    public function hasPrevious(): bool;

    /**
     * Returns whether the current Page is the first one.
     *
     * @return bool
     */
    public function isFirst(): bool;

    /**
     * Returns whether the current Page is the last one.
     *
     * @return bool
     */
    public function isLast(): bool;

    /**
     * Returns if there is a next Page.
     *
     * @return bool
     */
    public function hasNext(): bool;

    /**
     * Returns the size of the Page.
     *
     * @return int
     */
    public function pageSize(): int;

    /**
     * Returns the number of the current Page.
     *
     * @return int
     */
    public function pageNumber(): int;

    /**
     * Returns the number of total pages.
     *
     * @return int
     */
    public function totalPages(): int;

    /**
     * Returns the Pageable to request the next Page.
     *
     * @return Pageable
     */
    public function nextPageable(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable;

    /**
     * Returns the sorting parameters for the Page.
     *
     * @return Sort
     */
    public function sortings(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Sort;

    /**
     * @return Filter
     */
    public function filters(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter;

    /**
     * Returns the Pageable to request the previous Page.
     *
     * @return Pageable
     */
    public function previousPageable(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable;

    /**
     * Returns the total amount of elements.
     *
     * @return int
     */
    public function totalElements(): int;

    /**
     * Returns a new Page with the content of the current one mapped by the $converter callable.
     *
     * @param callable $converter
     *
     * @return Page
     */
    public function map(callable $converter): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Page;

    /**
     * @return Fields
     */
    public function fields(): \NilPortugues\Foundation\Domain\Model\Repository\Contracts\Fields;
}
