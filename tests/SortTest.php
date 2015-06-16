<?php

namespace PhpDdd\Tests\Foundation\Domain\Repository;

use InvalidArgumentException;
use PhpDdd\Foundation\Domain\Repository\Collection\Collection;
use PhpDdd\Foundation\Domain\Repository\Order;
use PhpDdd\Foundation\Domain\Repository\Sort;
use PHPUnit_Framework_TestCase;

class SortTest extends PHPUnit_Framework_TestCase
{
    public function testItCanGetByPropertyName()
    {
        $properties = ['size'];
        $order = new Order('ASC');
        $sort = new Sort($properties, $order);

        $this->assertEquals(new Order('ASC'), $sort->getProperty('size'));
    }

    public function testItThrowsExceptionIfPropertyNameNotFound()
    {
        $properties = [];
        $sort = new Sort($properties);

        $this->setExpectedException(InvalidArgumentException::class);
        $sort->getProperty('aPropertyName');
    }

    public function testItCanAddSorting()
    {
        $sortAsc = new Sort(['size', 'pages'], new Order('ASC'));
        $sortDesc = new Sort(['words'], new Order('DESC'));

        $mergedSort = $sortAsc->andSort($sortDesc);

        $expected = new Collection();
        $expected['size'] = new Order('ASC');
        $expected['pages'] = new Order('ASC');
        $expected['words'] = new Order('DESC');

        $this->assertEquals($expected, $mergedSort->getProperties());
    }

    public function testItCanSetOrderForAProperty()
    {
        $sort = new Sort();
        $sort->setOrderFor('size', new Order('ASC'));

        $this->assertEquals(new Order('ASC'), $sort->getOrderFor('size'));
    }

    public function testItCanCheckIfEqual()
    {
        $sort1 = new Sort();
        $sort2 = new Sort();

        $sort1->setOrderFor('size', new Order('ASC'));
        $sort2->setOrderFor('size', new Order('ASC'));

        $this->assertTrue($sort1->equals($sort2));
        $this->assertTrue($sort2->equals($sort1));
    }
}
