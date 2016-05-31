<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/15/15
 * Time: 11:08 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Fields as FieldsInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter as FilterInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable as PageableInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Sort as SortInterface;

class Pageable implements PageableInterface
{
    /**
     * @var int
     */
    protected $pageNumber;
    /**
     * @var int
     */
    protected $pageSize;
    /**
     * @var Sort
     */
    protected $sort;
    /**
     * @var FilterInterface
     */
    protected $filter;

    /**
     * @var FieldsInterface
     */
    protected $fields;

    /**
     * @var FieldsInterface
     */
    protected $distinctFields;

    /**
     * Pageable constructor.
     *
     * @param                      $pageNumber
     * @param                      $pageSize
     * @param SortInterface|null   $sort
     * @param FilterInterface|null $filter
     * @param FieldsInterface|null $fields
     * @param FieldsInterface|null $distinctFields
     */
    public function __construct(
        $pageNumber,
        $pageSize,
        SortInterface $sort = null,
        FilterInterface $filter = null,
        FieldsInterface $fields = null,
        FieldsInterface $distinctFields = null
    ) {
        $this->pageNumber = (int) $pageNumber;
        $this->pageSize = (int) $pageSize;
        $this->sort = ($sort) ? $sort : Sort::null();
        $this->filter = ($filter) ? $filter : Filter::null();
        $this->fields = ($fields) ? $fields : Fields::null();
        $this->distinctFields = ($distinctFields) ? $distinctFields : Fields::null();
    }

    /**
     * Returns the offset to be taken according to the underlying page and page size.
     *
     * @return int
     */
    public function offset(): int
    {
        $offset = $this->pageNumber();

        return ($offset > 0) ? ($offset) * $this->pageSize : $this->pageSize;
    }

    /**
     * Returns the page to be returned.
     *
     * @return int
     */
    public function pageNumber(): int
    {
        return ($this->pageNumber < 1) ? 1 : $this->pageNumber;
    }

    /**
     * Returns the sorting parameters.
     *
     * @return SortInterface
     */
    public function sortings(): SortInterface
    {
        return $this->sort;
    }

    /**
     * Returns the Pageable requesting the next Page.
     *
     * @return PageableInterface
     */
    public function next(): PageableInterface
    {
        return new self($this->pageNumber() + 1, $this->pageSize(), $this->sort, $this->filter, $this->fields);
    }

    /**
     * Returns the number of items to be returned.
     *
     * @return int
     */
    public function pageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * Returns the previous Pageable or the first Pageable if the current one already is the first one.
     *
     * @return PageableInterface
     */
    public function previousOrFirst(): PageableInterface
    {
        if ($this->hasPrevious()) {
            return new self($this->pageNumber() - 1, $this->pageSize(), $this->sort, $this->filter,
                $this->fields);
        }

        return $this->first();
    }

    /**
     * Returns whether there's a previous Pageable we can access from the current one.
     *
     * @return bool
     */
    public function hasPrevious(): bool
    {
        return ($this->pageNumber() - 1) > 0;
    }

    /**
     * Returns the Pageable requesting the first page.
     *
     * @return PageableInterface
     */
    public function first(): PageableInterface
    {
        return new self(1, $this->pageSize(), $this->sort, $this->filter, $this->fields);
    }

    /**
     * @return FilterInterface
     */
    public function filters(): FilterInterface
    {
        return $this->filter;
    }

    /**
     * @return FieldsInterface
     */
    public function fields(): FieldsInterface
    {
        return $this->fields;
    }

    /**
     * Returns value for `distinctFields`.
     *
     * @return FieldsInterface
     */
    public function distinctFields(): FieldsInterface
    {
        return $this->distinctFields;
    }
}
