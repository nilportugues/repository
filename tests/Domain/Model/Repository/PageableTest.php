<?php

namespace NilPortugues\Tests\Foundation\Domain\Model\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Fields;
use NilPortugues\Foundation\Domain\Model\Repository\Filter;
use NilPortugues\Foundation\Domain\Model\Repository\Pageable;
use NilPortugues\Foundation\Domain\Model\Repository\Sort;
use PHPUnit_Framework_TestCase;

class PageableTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $filterableAttributes = [
        'name',
        'author',
        'publisher',
        'publication_date',
        'tags',
    ];

    public function testReturnsFirstPageable()
    {
        $pageable = new Pageable(
            100,
            20,
            new Sort(),
            new Filter($this->filterableAttributes),
            new Fields()
        );
        $result = $pageable->first();

        $this->assertEquals(1, $result->pageNumber());
        $this->assertEquals(20, $result->pageSize());
        $this->assertFalse($result->hasPrevious());
        $this->assertEquals(20, $result->offset());
        $this->assertEquals(new Sort(), $result->sortings());
        $this->assertEquals(new Fields(), $result->fields());
        $this->assertEquals(new Filter($this->filterableAttributes), $result->filters());
    }

    public function testReturnsNextPageable()
    {
        $pageable = new Pageable(100, 20, new Sort(), new Filter($this->filterableAttributes));
        $result = $pageable->next();

        $this->assertEquals(101, $result->pageNumber());
        $this->assertEquals(20, $result->pageSize());
        $this->assertTrue($result->hasPrevious());
        $this->assertEquals(2020, $result->offset());
        $this->assertEquals(new Sort(), $result->sortings());
        $this->assertEquals(new Filter($this->filterableAttributes), $result->filters());
    }

    public function testReturnsPreviousPageable()
    {
        $pageable = new Pageable(100, 20, new Sort(), new Filter($this->filterableAttributes));
        $result = $pageable->previousOrFirst();

        $this->assertEquals(99, $result->pageNumber());
        $this->assertEquals(20, $result->pageSize());
        $this->assertTrue($result->hasPrevious());
        $this->assertEquals(1980, $result->offset());
        $this->assertEquals(new Sort(), $result->sortings());
        $this->assertEquals(new Filter($this->filterableAttributes), $result->filters());
    }

    public function testPreviousOrFirstReturnsFirstPageable()
    {
        $pageable = new Pageable(1, 20, new Sort(), new Filter($this->filterableAttributes));
        $result = $pageable->previousOrFirst();

        $this->assertEquals(1, $result->pageNumber());
        $this->assertEquals(20, $result->pageSize());
        $this->assertFalse($result->hasPrevious());
        $this->assertEquals(20, $result->offset());
        $this->assertEquals(new Sort(), $result->sortings());
        $this->assertEquals(new Filter($this->filterableAttributes), $result->filters());
    }
}
