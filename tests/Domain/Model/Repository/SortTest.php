<?php

namespace NilPortugues\Tests\Foundation\Domain\Model\Repository;

use InvalidArgumentException;
use NilPortugues\Foundation\Domain\Model\Repository\Order;
use NilPortugues\Foundation\Domain\Model\Repository\Sort;
use PHPUnit_Framework_TestCase;

class SortTest extends PHPUnit_Framework_TestCase
{
    public function testItCanGetByPropertyName()
    {
        $properties = ['size'];
        $order = new Order('ASC');
        $sort = new Sort($properties, $order);

        $this->assertEquals(new Order('ASC'), $sort->property('size'));
    }

    public function testItThrowsExceptionIfPropertyNameNotFound()
    {
        $properties = [];
        $sort = new Sort($properties);

        $this->setExpectedException(InvalidArgumentException::class);
        $sort->property('aPropertyName');
    }

    public function testItCanAddSorting()
    {
        $originalSort = new Sort(['size', 'pages'], new Order('ASC'));
        $sortDesc = new Sort(['words'], new Order('DESC'));

        $originalSort->andSort($sortDesc);

        $expected = [];
        $expected['size'] = new Order('ASC');
        $expected['pages'] = new Order('ASC');
        $expected['words'] = new Order('DESC');

        $this->assertEquals($expected, $originalSort->orders());
    }

    public function testItCanSetOrderForAProperty()
    {
        $sort = new Sort();
        $sort->setOrderFor('size', new Order('ASC'));

        $this->assertEquals(new Order('ASC'), $sort->orderFor('size'));
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
