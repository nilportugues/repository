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
    public function offset();

    /**
     * @return int
     */
    public function pageNumber();

    /**
     * @return Sort
     */
    public function sortings();

    /**
     * @return Pageable
     */
    public function next();

    /**
     * @return int
     */
    public function pageSize();

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
     * @return Filter
     */
    public function filters();

    /**
     * @return Fields
     */
    public function fields();
}
