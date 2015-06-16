<?php
namespace PhpDdd\Tests\Foundation\Domain\Repository;

use PhpDdd\Foundation\Domain\Repository\Filter;
use PhpDdd\Foundation\Domain\Repository\Pageable;
use PhpDdd\Foundation\Domain\Repository\Sort;
use PHPUnit_Framework_TestCase;

class PageableTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsFirstPageable()
    {
        $pageable = new Pageable(100, 20, new Sort(), new Filter());
        $result = $pageable->first();

        $this->assertEquals(1, $result->getPageNumber());
        $this->assertEquals(20, $result->getPageSize());
        $this->assertFalse($result->hasPrevious());
        $this->assertEquals(20, $result->getOffset());
        $this->assertEquals(new Sort(), $result->getSort());
        $this->assertEquals(new Filter(), $result->getFilter());
    }

    public function testReturnsNextPageable()
    {
        $pageable = new Pageable(100, 20, new Sort(), new Filter());
        $result = $pageable->next();

        $this->assertEquals(101, $result->getPageNumber());
        $this->assertEquals(20, $result->getPageSize());
        $this->assertTrue($result->hasPrevious());
        $this->assertEquals(2020, $result->getOffset());
        $this->assertEquals(new Sort(), $result->getSort());
        $this->assertEquals(new Filter(), $result->getFilter());
    }

    public function testReturnsPreviousPageable()
    {
        $pageable = new Pageable(100, 20, new Sort(), new Filter());
        $result = $pageable->previousOrFirst();

        $this->assertEquals(99, $result->getPageNumber());
        $this->assertEquals(20, $result->getPageSize());
        $this->assertTrue($result->hasPrevious());
        $this->assertEquals(1980, $result->getOffset());
        $this->assertEquals(new Sort(), $result->getSort());
        $this->assertEquals(new Filter(), $result->getFilter());
    }

    public function testPreviousOrFirstReturnsFirstPageable()
    {
        $pageable = new Pageable(1, 20, new Sort(), new Filter());
        $result = $pageable->previousOrFirst();

        $this->assertEquals(1, $result->getPageNumber());
        $this->assertEquals(20, $result->getPageSize());
        $this->assertFalse($result->hasPrevious());
        $this->assertEquals(20, $result->getOffset());
        $this->assertEquals(new Sort(), $result->getSort());
        $this->assertEquals(new Filter(), $result->getFilter());
    }
}
