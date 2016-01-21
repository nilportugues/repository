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
     */
    public function __construct(
        $pageNumber,
        $pageSize,
        Sort $sort = null,
        Filter $filter = null,
        Fields $fields = null
    );

    /**
     * @return int
     */
    public function getOffset();

    /**
     * @return int
     */
    public function getPageNumber();

    /**
     * @return Sort
     */
    public function getSort();

    /**
     * @return Pageable
     */
    public function next();

    /**
     * @return int
     */
    public function getPageSize();

    /**
     * @return Pageable
     */
    public function previousOrFirst();

    /**
     * @return bool
     */
    public function hasPrevious();

    /**
     * @return Pageable
     */
    public function first();

    /**
     * @return Pageable
     */
    public function last();

    /**
     * @return Filter
     */
    public function getFilter();

    /**
     * @return Fields
     */
    public function getFields();
}
