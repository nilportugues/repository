<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/15/15
 * Time: 11:31 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\DDDFoundation\Domain\Repository;

use NilPortugues\DDDFoundation\Domain\Repository\Collection\ImmutableCollection;

class Page
{
    /**
     * @var ImmutableCollection
     */
    private $elements;
    /**
     * @var int
     */
    private $totalPages;
    /**
     * @var int
     */
    private $totalElements;
    /**
     * @var int
     */
    private $pageNumber;
    /**
     * @var Sort
     */
    private $sort;
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @param array  $elements
     * @param        $totalElements
     * @param        $pageNumber
     * @param        $totalPages
     * @param Sort   $sort
     * @param Filter $filter
     */
    public function __construct(array $elements, $totalElements, $pageNumber, $totalPages, Sort $sort, Filter $filter)
    {
        $this->elements      = ImmutableCollection::fromArray($elements);
        $this->totalElements = (int) $totalElements;
        $this->pageNumber    = (int) $pageNumber;
        $this->totalPages    = (int) $totalPages;
        $this->sort          = $sort;
        $this->filter        = $filter;
    }

    /**
     * Returns the page content as an array.
     *
     * @return ImmutableCollection
     */
    public function getContent()
    {
        return $this->elements;
    }

    /**
     * Returns if there is a previous Page.
     *
     * @return bool
     */
    public function hasPrevious()
    {
        return $this->pageNumber > 0;
    }

    /**
     * Returns whether the current Page is the first one.
     *
     * @return bool
     */
    public function isFirst()
    {
        return 1 === $this->pageNumber;
    }

    /**
     * Returns whether the current Page is the last one.
     *
     * @return bool
     */
    public function isLast()
    {
        return false === $this->hasNext();
    }

    /**
     * Returns if there is a next Page.
     *
     * @return bool
     */
    public function hasNext()
    {
        return $this->getPageSize() * $this->getNumber() < $this->getTotalPages();
    }

    /**
     * Returns the size of the Page.
     *
     * @return int
     */
    public function getPageSize()
    {
        return count($this->elements);
    }

    /**
     * Returns the number of the current Page.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->pageNumber;
    }

    /**
     * Returns the number of total pages.
     *
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * Returns the Pageable to request the next Page.
     *
     * @return Pageable
     */
    public function nextPageable()
    {
        return new Pageable($this->getNumber() + 1, $this->getPageSize(), $this->getSort(), $this->getFilter());
    }

    /**
     * Returns the sorting parameters for the Page.
     *
     * @return Sort
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Returns the Pageable to request the previous Page.
     *
     * @return Pageable
     */
    public function previousPageable()
    {
        $pageable = new Pageable($this->getNumber(), $this->getPageSize(), $this->getSort(), $this->getFilter());

        return $pageable->previousOrFirst();
    }

    /**
     * Returns the total amount of elements.
     *
     * @return int
     */
    public function getTotalElements()
    {
        return $this->totalElements;
    }

    /**
     * Returns a new Page with the content of the current one mapped by the $converter callable.
     *
     * @param callable $converter
     *
     * @return Page
     */
    public function map(callable $converter)
    {
        $collection = new ImmutableCollection($this->getNumber());

        foreach ($this->elements as $element) {
            $collection[] = $converter($element);
        }

        return new self(
            $collection,
            $this->totalElements,
            $this->pageNumber,
            $this->totalPages,
            $this->sort,
            $this->filter
        );
    }
}
