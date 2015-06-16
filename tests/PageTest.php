<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 8:26 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Tests\Foundation\Domain\Repository;

use PhpDdd\Foundation\Domain\Repository\Filter;
use PhpDdd\Foundation\Domain\Repository\Page;
use PhpDdd\Foundation\Domain\Repository\Sort;
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


    protected function setUp()
    {
        $this->elements      = ['Bulbasaur', 'Charmander', 'Squirtle'];
        $this->pageSize      = count($this->elements);
        $this->pageNumber    = 3;
        $this->totalPages    = 20;
        $this->totalElements = 151;
        $this->sort          = new Sort();
        $this->filter        = new Filter();

        $this->page = new Page(
            $this->elements,
            $this->totalElements,
            $this->pageNumber,
            $this->totalPages,
            $this->sort,
            $this->filter
        );
    }

    protected function tearDown()
    {
        $this->elements      = null;
        $this->pageSize      = null;
        $this->pageNumber    = null;
        $this->totalPages    = null;
        $this->totalElements = null;
        $this->sort          = null;
        $this->filter        = null;
        $this->page          = null;
    }

    public function testItCanConstruct()
    {
        $this->assertEquals($this->totalElements, $this->page->getTotalElements());
        $this->assertEquals($this->pageNumber, $this->page->getPageNumber());
        $this->assertEquals($this->totalPages, $this->page->getTotalPages());
        $this->assertEquals($this->sort, $this->page->getSort());
        $this->assertEquals($this->filter, $this->page->getFilter());

        $this->assertTrue($this->page->hasNext());
        $this->assertTrue($this->page->hasPrevious());

        $this->assertFalse($this->page->isLast());
        $this->assertFalse($this->page->isFirst());

        $this->assertEquals($this->pageSize, $this->page->getPageSize());
        foreach ($this->elements as $key => $element) {
            $this->assertEquals($element, $this->page->getContent()[$key]);
        }
    }


    public function testItCanCalculatePreviousPageable()
    {
        $previousPageable = $this->page->previousPageable();
        $this->assertEquals(2, $previousPageable->getPageNumber());
        $this->assertEquals($this->pageSize, $previousPageable->getPageSize());
        $this->assertEquals($this->sort, $previousPageable->getSort());
        $this->assertEquals($this->filter, $previousPageable->getFilter());
    }

    public function testItCanCalculateNextPageable()
    {
        $nextPageable = $this->page->nextPageable();
        $this->assertEquals(4, $nextPageable->getPageNumber());
        $this->assertEquals($this->pageSize, $nextPageable->getPageSize());
        $this->assertEquals($this->sort, $nextPageable->getSort());
        $this->assertEquals($this->filter, $nextPageable->getFilter());
    }

    public function testItCanCreateANewPageFromCallableMap()
    {
        $convert = function ($element) {
            $stdClass = new stdClass();
            $stdClass->name = $element;
            return $stdClass;
        };

        $page = $this->page->map($convert);

        foreach ($page->getContent() as $key => $value) {
            $this->assertInstanceOf(stdClass::class, $value);
            $this->assertEquals($this->elements[$key], $value->name);
        }
    }
}
