<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/15/15
 * Time: 11:31 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Collections\ImmutableTypedCollection;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Fields as FieldsInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter as FilterInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Page as PageInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable as PageableInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Sort as SortInterface;

class Page implements PageInterface
{
    /**
     * @var ImmutableTypedCollection
     */
    protected $elements;
    /**
     * @var int
     */
    protected $totalPages;
    /**
     * @var int
     */
    protected $totalElements;
    /**
     * @var int
     */
    protected $pageNumber;
    /**
     * @var SortInterface
     */
    protected $sort;
    /**
     * @var FilterInterface
     */
    protected $filter;

    /**
     * @var Fields
     */
    protected $fields;

    /**
     * Page constructor.
     *
     * @param array           $elements
     * @param                 $totalElements
     * @param                 $pageNumber
     * @param                 $totalPages
     * @param SortInterface   $sort
     * @param FilterInterface $filter
     * @param FieldsInterface $fields
     */
    public function __construct(
        array $elements,
        $totalElements,
        $pageNumber,
        $totalPages,
        SortInterface $sort = null,
        FilterInterface $filter = null,
        FieldsInterface $fields = null
    ) {
        $this->elements      = ImmutableTypedCollection::fromArray($elements);
        $this->totalElements = (int)$totalElements;
        $this->pageNumber    = (int)$pageNumber;
        $this->totalPages    = (int)$totalPages;
        $this->sort          = ($sort) ? $sort : new Sort();
        $this->filter        = ($filter) ? $filter : new Filter();
        $this->fields        = ($fields) ? $fields : new Fields();
    }

    /**
     * Returns the page content as an array.
     *
     * @return ImmutableTypedCollection
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
        return $this->pageNumber > 1;
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
        return $this->getPageSize() * $this->getPageNumber() < $this->getTotalPages();
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
    public function getPageNumber()
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
     * @return PageableInterface
     */
    public function nextPageable()
    {
        return new Pageable(
            $this->getPageNumber() + 1,
            $this->getPageSize(),
            $this->getSort(),
            $this->getFilter(),
            $this->getFields()
        );
    }

    /**
     * Returns the sorting parameters for the Page.
     *
     * @return SortInterface
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return FilterInterface
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return FieldsInterface
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Returns the Pageable to request the previous Page.
     *
     * @return PageableInterface
     */
    public function previousPageable()
    {
        $pageable = new Pageable(
            $this->getPageNumber(),
            $this->getPageSize(),
            $this->getSort(),
            $this->getFilter(),
            $this->getFields()
        );

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
     * @return PageInterface
     */
    public function map(callable $converter)
    {
        $collection = [];
        foreach ($this->elements as $key => $element) {
            $collection[$key] = $converter($element);
        }

        return new self(
            $collection,
            $this->totalElements,
            $this->pageNumber,
            $this->totalPages,
            $this->sort,
            $this->filter,
            $this->fields
        );
    }
}
