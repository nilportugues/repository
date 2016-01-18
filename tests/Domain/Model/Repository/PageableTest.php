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

        $this->assertEquals(1, $result->getPageNumber());
        $this->assertEquals(20, $result->getPageSize());
        $this->assertFalse($result->hasPrevious());
        $this->assertEquals(20, $result->getOffset());
        $this->assertEquals(new Sort(), $result->getSort());
        $this->assertEquals(new Fields(), $result->getFields());
        $this->assertEquals(new Filter($this->filterableAttributes), $result->getFilter());
    }

    public function testReturnsNextPageable()
    {
        $pageable = new Pageable(100, 20, new Sort(), new Filter($this->filterableAttributes));
        $result = $pageable->next();

        $this->assertEquals(101, $result->getPageNumber());
        $this->assertEquals(20, $result->getPageSize());
        $this->assertTrue($result->hasPrevious());
        $this->assertEquals(2020, $result->getOffset());
        $this->assertEquals(new Sort(), $result->getSort());
        $this->assertEquals(new Filter($this->filterableAttributes), $result->getFilter());
    }

    public function testReturnsPreviousPageable()
    {
        $pageable = new Pageable(100, 20, new Sort(), new Filter($this->filterableAttributes));
        $result = $pageable->previousOrFirst();

        $this->assertEquals(99, $result->getPageNumber());
        $this->assertEquals(20, $result->getPageSize());
        $this->assertTrue($result->hasPrevious());
        $this->assertEquals(1980, $result->getOffset());
        $this->assertEquals(new Sort(), $result->getSort());
        $this->assertEquals(new Filter($this->filterableAttributes), $result->getFilter());
    }

    public function testPreviousOrFirstReturnsFirstPageable()
    {
        $pageable = new Pageable(1, 20, new Sort(), new Filter($this->filterableAttributes));
        $result = $pageable->previousOrFirst();

        $this->assertEquals(1, $result->getPageNumber());
        $this->assertEquals(20, $result->getPageSize());
        $this->assertFalse($result->hasPrevious());
        $this->assertEquals(20, $result->getOffset());
        $this->assertEquals(new Sort(), $result->getSort());
        $this->assertEquals(new Filter($this->filterableAttributes), $result->getFilter());
    }
}
