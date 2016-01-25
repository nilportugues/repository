<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 8:26 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Tests\Foundation\Domain\Model\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Fields;
use NilPortugues\Foundation\Domain\Model\Repository\Filter;
use NilPortugues\Foundation\Domain\Model\Repository\Page;
use NilPortugues\Foundation\Domain\Model\Repository\Sort;
use PHPUnit_Framework_TestCase;
use stdClass;

class PageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var Sort
     */
    private $sort;
    /**
     * @var int
     */
    private $totalPages;
    /**
     * @var int
     */
    private $pageNumber;
    /**
     * @var int
     */
    private $totalElements;
    /**
     * @var array
     */
    private $elements;
    /**
     * @var Page
     */
    private $page;
    /**
     * @var int
     */
    private $pageSize;

    /**
     * @var array
     */
    private $filterAttributes = ['name'];

    /**
     * @var Fields
     */
    private $fields;

    protected function setUp()
    {
        $this->elements = ['Bulbasaur', 'Charmander', 'Squirtle'];
        $this->pageSize = count($this->elements);
        $this->pageNumber = 3;
        $this->totalPages = 20;
        $this->totalElements = 151;
        $this->sort = new Sort();
        $this->filter = new Filter($this->filterAttributes);
        $this->fields = new Fields();

        $this->page = new Page(
            $this->elements,
            $this->totalElements,
            $this->pageNumber,
            $this->totalPages,
            $this->sort,
            $this->filter,
            $this->fields
        );
    }

    protected function tearDown()
    {
        $this->elements = null;
        $this->pageSize = null;
        $this->pageNumber = null;
        $this->totalPages = null;
        $this->totalElements = null;
        $this->sort = null;
        $this->filter = null;
        $this->fields = null;
        $this->page = null;
    }

    public function testItCanConstruct()
    {
        $this->assertEquals($this->totalElements, $this->page->totalElements());
        $this->assertEquals($this->pageNumber, $this->page->pageNumber());
        $this->assertEquals($this->totalPages, $this->page->totalPages());
        $this->assertEquals($this->sort, $this->page->sortings());
        $this->assertEquals($this->filter, $this->page->filters());
        $this->assertEquals($this->fields, $this->page->fields());

        $this->assertTrue($this->page->hasNext());
        $this->assertTrue($this->page->hasPrevious());

        $this->assertFalse($this->page->isLast());
        $this->assertFalse($this->page->isFirst());

        $this->assertEquals($this->pageSize, $this->page->pageSize());
        foreach ($this->elements as $key => $element) {
            $this->assertEquals($element, $this->page->content()[$key]);
        }
    }

    public function testItCanCalculatePreviousPageable()
    {
        $previousPageable = $this->page->previousPageable();
        $this->assertEquals(2, $previousPageable->pageNumber());
        $this->assertEquals($this->pageSize, $previousPageable->pageSize());
        $this->assertEquals($this->sort, $previousPageable->sortings());
        $this->assertEquals($this->filter, $previousPageable->filters());
        $this->assertEquals($this->fields, $previousPageable->fields());
    }

    public function testItCanCalculateNextPageable()
    {
        $nextPageable = $this->page->nextPageable();
        $this->assertEquals(4, $nextPageable->pageNumber());
        $this->assertEquals($this->pageSize, $nextPageable->pageSize());
        $this->assertEquals($this->sort, $nextPageable->sortings());
        $this->assertEquals($this->filter, $nextPageable->filters());
        $this->assertEquals($this->fields, $nextPageable->fields());
    }

    public function testItCanCreateANewPageFromCallableMap()
    {
        $convert = function ($element) {
            $stdClass = new stdClass();
            $stdClass->name = $element;

            return $stdClass;
        };

        $page = $this->page->map($convert);

        foreach ($page->content() as $key => $value) {
            $this->assertInstanceOf(stdClass::class, $value);
            $this->assertEquals($this->elements[$key], $value->name);
        }
    }
}
