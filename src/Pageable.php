<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/15/15
 * Time: 11:08 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\DDDFoundation\Domain\Repository;

use NilPortugues\DDDFoundation\Domain\Repository\Collection\Collection;

final class Pageable extends Collection
{
    /**
     * @var int
     */
    private $pageNumber;
    /**
     * @var int
     */
    private $pageSize;
    /**
     * @var Sort
     */
    private $sort;
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @param int    $pageNumber
     * @param int    $pageSize
     * @param Sort   $sort
     * @param Filter $filter
     */
    public function __construct($pageNumber, $pageSize, Sort $sort = null, Filter $filter = null)
    {
        $this->pageNumber = (int) $pageNumber;
        $this->pageSize = (int) $pageSize;
        $this->sort = $sort;
        $this->filter = $filter;
    }

    /**
     * Returns the Pageable requesting the first page.
     *
     * @return Pageable
     */
    public function first()
    {
        return new self(0, $this->getPageSize(), $this->sort, $this->filter);
    }

    /**
     * Returns the offset to be taken according to the underlying page and page size.
     *
     * @return int
     */
    public function getOffset()
    {
        $offset = $this->getPageNumber() - 1;

        return ($offset>0) ? $offset*$this->pageSize : $this->pageSize;
    }

    /**
     * Returns the page to be returned.
     *
     * @return int
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * Returns the number of items to be returned.
     *
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Returns the sorting parameters.
     * @return Sort
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Returns whether there's a previous Pageable we can access from the current one.
     * @return bool
     */
    public function hasPrevious()
    {
        return $this->getOffset()>0;
    }

    /**
     * Returns the Pageable requesting the next Page.
     * @return Pageable
     */
    public function next()
    {
        return new self($this->getPageNumber()+1, $this->getPageSize(), $this->sort, $this->filter);
    }

    /**
     * Returns the previous Pageable or the first Pageable if the current one already is the first one.
     * @return Pageable
     */
    public function previousOrFirst()
    {
        if ($this->hasPrevious()) {
            return new self($this->getPageNumber()-1, $this->getPageSize(), $this->sort, $this->filter);
        }

        return $this->first();
    }
}
