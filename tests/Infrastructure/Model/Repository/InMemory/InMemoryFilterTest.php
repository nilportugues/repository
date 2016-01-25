<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 22/01/16
 * Time: 21:01.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory;

use DateTime;
use Exception;
use NilPortugues\Foundation\Domain\Model\Repository\Filter;
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\InMemoryFilter;
use NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies\Clients;
use stdClass;

class InMemoryFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $data = [];

    public function setUp()
    {
        $this->data = [
            new Clients(
                'John Doe',
                new DateTime('2014-12-11'),
                3,
                [
                    new DateTime('2014-12-16'),
                    new DateTime('2014-12-31'),
                    new DateTime('2015-03-11'),
                ],
                25.125
            ),
            new Clients(
                'Junichi Masuda',
                new DateTime('2013-02-22'),
                3,
                [
                    new DateTime('2014-04-16'),
                    new DateTime('2015-12-31'),
                    new DateTime('2016-04-31'), ],
                50978.125
            ),
            new Clients(
                'Shigeru Miyamoto',
                new DateTime('2010-12-01'),
                5,
                [
                    new DateTime('1999-04-16'),
                    new DateTime('1996-02-04'),
                    new DateTime('1992-06-01'),
                    new DateTime('2000-03-01'),
                    new DateTime('2002-09-11'),
                ],
                47889850.125
            ),
            new Clients(
                'Ken Sugimori',
                new DateTime('2010-12-10'),
                4,
                [
                    new DateTime('1996-06-30'),
                    new DateTime('1992-09-25'),
                    new DateTime('2000-08-09'),
                    new DateTime('2002-07-15'),
                ],
                69158.687
            ),
        ];
    }

    public function testItMustRangeBetweenTwoScalars()
    {
        $filter = new Filter();
        $filter->must()->ranges('totalOrders', 4, 5);

        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(2, count($results));

        $names = ['Ken Sugimori', 'Shigeru Miyamoto'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItMustRangeOfDifferentTypesThrowsException()
    {
        $filter = new Filter();
        $filter->must()->ranges('totalOrders', 4, new stdClass());

        $this->setExpectedException(Exception::class);
        InMemoryFilter::filter($this->data, $filter);
    }

    public function testItMustRangeBetweenTwoObjects()
    {
        $filter = new Filter();
        $filter->must()->ranges('date', new DateTime('2010-12-01'), new DateTime('2010-12-10'));

        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(2, count($results));

        $names = ['Ken Sugimori', 'Shigeru Miyamoto'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItMustNotRangeOfDifferentTypesThrowsException()
    {
        $filter = new Filter();
        $filter->must()->notRanges('totalOrders', 4, new stdClass());

        $this->setExpectedException(Exception::class);
        InMemoryFilter::filter($this->data, $filter);
    }

    public function testItMustNotRangeBetweenTwoScalars()
    {
        $filter = new Filter();
        $filter->must()->notRanges('totalOrders', 4, 5);

        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(2, count($results));

        $names = ['John Doe', 'Junichi Masuda'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItMustNotRangeBetweenTwoObjects()
    {
        $filter = new Filter();
        $filter->must()->notRanges('date', new DateTime('2010-12-01'), new DateTime('2010-12-10'));

        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(2, count($results));

        $names = ['John Doe', 'Junichi Masuda'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItContainsScalar()
    {
        $filter = new Filter();
        $filter->must()->contains('name', 'a');
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(2, count($results));

        $names = ['Shigeru Miyamoto', 'Junichi Masuda'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItContainsObjectInArray()
    {
        $filter = new Filter();
        $filter->must()->contains('orderDates', new DateTime('1999-04-16'));

        $results = InMemoryFilter::filter($this->data, $filter);
        $names = ['Shigeru Miyamoto'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItNotContainsScalar()
    {
        $filter = new Filter();
        $filter->must()->notContains('name', 'a');
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(2, count($results));

        $names = ['Ken Sugimori', 'John Doe'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItNotContainsObjectInArray()
    {
        $filter = new Filter();
        $filter->must()->notContains('orderDates', new DateTime('1999-04-16'));

        $results = InMemoryFilter::filter($this->data, $filter);
        $names = ['John Doe', 'Junichi Masuda', 'Ken Sugimori'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItStartsWithScalar()
    {
        $filter = new Filter();
        $filter->must()->startsWith('name', 'Ken');
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(1, count($results));
    }

    public function testItStartsWithScalarThrowsException()
    {
        $filter = new Filter();
        $filter->must()->startsWith('orderDates', 'Masuda');

        $this->setExpectedException(Exception::class);
        InMemoryFilter::filter($this->data, $filter);
    }

    public function testItStartsWithObjectThrowsException()
    {
        $filter = new Filter();
        $filter->must()->startsWith('name', new stdClass());

        $this->setExpectedException(Exception::class);
        InMemoryFilter::filter($this->data, $filter);
    }

    public function testItEndsWithScalar()
    {
        $filter = new Filter();
        $filter->must()->endsWith('name', 'Masuda');
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(1, count($results));
    }

    public function testItEndsWithScalarThrowsException()
    {
        $filter = new Filter();
        $filter->must()->endsWith('orderDates', 'Masuda');

        $this->setExpectedException(Exception::class);
        InMemoryFilter::filter($this->data, $filter);
    }

    public function testItEndsWithObjectThrowsException()
    {
        $filter = new Filter();
        $filter->must()->endsWith('name', new stdClass());

        $this->setExpectedException(Exception::class);
        InMemoryFilter::filter($this->data, $filter);
    }

    public function testItEquals()
    {
        $filter = new Filter();
        $filter->must()->equals('name', 'Junichi Masuda');
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(1, count($results));
    }

    public function testItNotEquals()
    {
        $filter = new Filter();
        $filter->must()->notEquals('name', 'Junichi Masuda');
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(3, count($results));
    }

    public function testLessThan()
    {
        $filter = new Filter();
        $filter->must()->lessThan('totalEarnings', 100);
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(1, count($results));
    }

    public function testLessOrEqualThan()
    {
        $filter = new Filter();
        $filter->must()->lessThanOrEqual('totalEarnings', 25.125);
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(1, count($results));
    }

    public function testGreaterThan()
    {
        $filter = new Filter();
        $filter->must()->greaterThan('totalEarnings', 100);
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(3, count($results));
    }

    public function testGreaterOrEqualThan()
    {
        $filter = new Filter();
        $filter->must()->greaterThanOrEqual('totalEarnings', 25.125);
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(4, count($results));
    }

    public function testItBeInScalar()
    {
        $filter = new Filter();
        $filter->must()->includesGroup(
            'name',
            ['k', 'e', 'n']
        );
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(1, count($results));

        $names = ['Ken Sugimori'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItBeInArray()
    {
        $filter = new Filter();
        $filter->must()->includesGroup(
            'orderDates',
            [new DateTime('1999-04-16'), new DateTime('1996-02-04'), new DateTime('1992-06-01')]
        );
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(1, count($results));
    }

    public function testItBeNotInScalar()
    {
        $filter = new Filter();
        $filter->must()->notIncludesGroup(
            'name',
            ['k', 'e', 'n']
        );
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(3, count($results));

        $names = ['Ken Sugimori'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertNotContains($client->name(), $names);
        }
    }

    public function testItBeNotInArray()
    {
        $filter = new Filter();
        $filter->must()->notIncludesGroup(
            'orderDates',
            [new DateTime('1999-04-16'), new DateTime('1996-02-04'), new DateTime('1992-06-01')]
        );

        $results = InMemoryFilter::filter($this->data, $filter);
        $this->assertEquals(3, count($results));

        $names = ['John Doe', 'Junichi Masuda', 'Ken Sugimori'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }

    public function testItNotEndsWithScalar()
    {
        $filter = new Filter();
        $filter->mustNot()->endsWith('name', 'Masuda');
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(3, count($results));
        $names = ['John Doe', 'Shigeru Miyamoto', 'Ken Sugimori'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }
    public function testItNotStartsWithScalar()
    {
        $filter = new Filter();

        $filter->mustNot()->startsWith('name', 'Junichi');
        $results = InMemoryFilter::filter($this->data, $filter);

        $this->assertEquals(3, count($results));
        $names = ['John Doe', 'Shigeru Miyamoto', 'Ken Sugimori'];
        /** @var Clients $client */
        foreach ($results as $client) {
            $this->assertContains($client->name(), $names);
        }
    }
}
