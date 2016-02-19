<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 25/01/16
 * Time: 20:39.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory;

use DateTime;
use NilPortugues\Foundation\Domain\Model\Repository\Fields;
use NilPortugues\Foundation\Domain\Model\Repository\Filter;
use NilPortugues\Foundation\Domain\Model\Repository\Order;
use NilPortugues\Foundation\Domain\Model\Repository\Page;
use NilPortugues\Foundation\Domain\Model\Repository\Pageable;
use NilPortugues\Foundation\Domain\Model\Repository\Sort;
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\InMemoryRepository;
use NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies\Clients;
use NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies\ObjectId;

class InMemoryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    const CLIENT_ID_NO1 = 1;
    const CLIENT_ID_NO2 = 2;
    const CLIENT_ID_NO3 = 3;
    const CLIENT_ID_NO4 = 4;

    /**
     * @var InMemoryRepository
     */
    private $repository;

    public function setUp()
    {
        $data = [
            self::CLIENT_ID_NO1 => new Clients(
                self::CLIENT_ID_NO1,
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
            self::CLIENT_ID_NO2 => new Clients(
                self::CLIENT_ID_NO2,
                'Junichi Masuda',
                new DateTime('2013-02-22'),
                3,
                [
                    new DateTime('2014-04-16'),
                    new DateTime('2015-12-31'),
                    new DateTime('2016-04-31'), ],
                50978.125
            ),
            self::CLIENT_ID_NO3 => new Clients(
                self::CLIENT_ID_NO3,
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
            self::CLIENT_ID_NO4 => new Clients(
                self::CLIENT_ID_NO4,
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

        $this->repository = new InMemoryRepository($data);
    }


    public function testFindByMustNotIncludeGroupTest()
    {
        $filter = new Filter();
        $filter
            ->must()
            ->notIncludeGroup(
                'date',
                [new DateTime('2010-12-01'), new DateTime('2010-12-10'), new DateTime('2013-02-22')]
            );

        $results = $this->repository->findBy($filter);


        $this->assertEquals(1, count($results));
    }

    public function testFindAll()
    {
        $result = $this->repository->findAll();

        $this->assertInstanceOf(Page::class, $result);
        $this->assertEquals(4, count($result->content()));
    }

    public function testFindAllWithPageable()
    {
        $pageable = new Pageable(2, 2, new Sort(['name'], new Order('DESC')));
        $result = $this->repository->findAll($pageable);

        $this->assertInstanceOf(Page::class, $result);
        $this->assertEquals(2, count($result->content()));
    }

    public function testCount()
    {
        $this->assertEquals(4, $this->repository->count());
    }

    public function testCountWithFilter()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Ken');

        $this->assertEquals(1, $this->repository->count($filter));
    }

    public function testExists()
    {
        $this->assertTrue($this->repository->exists(new ObjectId(1)));
    }

    public function testAdd()
    {
        $client = new Clients(5, 'New Client', new DateTime('now'), 0, [], 0);
        $this->repository->add($client);

        $this->assertNotNull($this->repository->find(new ObjectId(5)));
    }

    public function testAddAll()
    {
        $clients = [
            new Clients(5, 'New Client 1', new DateTime('now'), 0, [], 0),
            new Clients(6, 'New Client 2', new DateTime('now'), 0, [], 0),
        ];
        $this->repository->addAll($clients);

        $this->assertNotNull($this->repository->find(new ObjectId(5)));
        $this->assertNotNull($this->repository->find(new ObjectId(6)));
    }

    public function testRemove()
    {
        $id = new ObjectId(1);
        $this->repository->remove($id);
        $this->assertFalse($this->repository->exists($id));
    }

    public function testRemoveAll()
    {
        $this->repository->removeAll();
        $this->assertFalse($this->repository->exists(new ObjectId(1)));
    }

    public function testRemoveAllWithFilter()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Doe');

        $this->repository->removeAll($filter);
        $this->assertFalse($this->repository->exists(new ObjectId(1)));
    }

    public function testFind()
    {
        $expected = new Clients(
            self::CLIENT_ID_NO4,
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
        );

        $this->assertEquals(
            $expected,
            $this->repository->find(new ObjectId(self::CLIENT_ID_NO4))
        );
    }

    public function testFindReturnsNullIfNotFound()
    {
        $this->assertNull($this->repository->find(new ObjectId(99999)));
    }

    public function testFindBy()
    {
        $sort = new Sort(['name'], new Order('ASC'));

        $filter = new Filter();
        $filter->must()->contain('name', 'Ken');

        $expected = [
            new Clients(
                4,
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

        $this->assertEquals($expected, $this->repository->findBy($filter, $sort));
    }

    public function testFindByWithEmptyRepository()
    {
        $repository = new InMemoryRepository();
        $sort = new Sort(['name'], new Order('ASC'));
        $filter = new Filter();
        $filter->must()->contain('name', 'Ken');

        $this->assertEquals([], $repository->findBy($filter, $sort));
    }


    //--------------------------------------------------------------------------------
    // MUST FILTER TESTS
    //--------------------------------------------------------------------------------

    public function testFindByMustRange()
    {
        $filter = new Filter();
        $filter->must()->range('totalOrders', 3, 4);

        $results = $this->repository->findBy($filter);

        $this->assertEquals(3, count($results));
    }

    public function testFindByMustNotRangeTest()
    {
        $filter = new Filter();
        $filter->must()->notRange('totalOrders', 2, 4);

        $results = $this->repository->findBy($filter);
        $this->assertEquals(1, count($results));
    }


    public function testFindByWithMustEqual()
    {
        $filter = new Filter();
        $filter->must()->equal('name', 'Ken Sugimori');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
        foreach ($results as $result) {
            $this->assertTrue(false !== strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustNotEqualTest()
    {
        $filter = new Filter();
        $filter->must()->notEqual('name', 'Ken Sugimori');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(3, count($results));
        foreach ($results as $result) {
            $this->assertFalse(strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustContain()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Ken');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
        foreach ($results as $result) {
            $this->assertTrue(false !== strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustNotContainTest()
    {
        $filter = new Filter();
        $filter->must()->notContain('name', 'Ken');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(3, count($results));
        foreach ($results as $result) {
            $this->assertFalse(strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustEndsWith()
    {
        $filter = new Filter();
        $filter->must()->endsWith('name', 'mori');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
        foreach ($results as $result) {
            $this->assertTrue(false !== strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustStartsWith()
    {
        $filter = new Filter();
        $filter->must()->startsWith('name', 'Ke');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
        foreach ($results as $result) {
            $this->assertTrue(false !== strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustBeLessThan()
    {
        $filter = new Filter();
        $filter->must()->beLessThan('totalOrders', 6);

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(4, count($results));
    }

    public function testFindByWithMustBeLessThanOrEqual()
    {
        $filter = new Filter();
        $filter->must()->beLessThanOrEqual('totalOrders', 4);

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(3, count($results));
    }

    public function testFindByWithMustBeGreaterThan()
    {
        $filter = new Filter();
        $filter->must()->beGreaterThan('totalOrders', 2);

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(4, count($results));
    }

    public function testFindByWithMustBeGreaterThanOrEqual()
    {
        $filter = new Filter();
        $filter->must()->beGreaterThanOrEqual('totalOrders', 2);

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(4, count($results));
    }

    public function testFindByMustIncludeGroup()
    {
        $filter = new Filter();
        $filter->must()->includeGroup(
            'date',
            [new DateTime('2010-12-01'), new DateTime('2010-12-10'), new DateTime('2013-02-22')]
        );

        $results = $this->repository->findBy($filter);

        $this->assertEquals(3, count($results));
    }

    //--------------------------------------------------------------------------------
    // MUST NOT FILTER TESTS
    //--------------------------------------------------------------------------------


    public function testFindByWithMustNotEqual()
    {
        $filter = new Filter();
        $filter->mustNot()->equal('name', 'Ken Sugimori');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(3, count($results));
        foreach ($results as $result) {
            $this->assertFalse(strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustNotNotEqual()
    {
        $filter = new Filter();
        $filter->mustNot()->notEqual('name', 'Ken Sugimori');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
        foreach ($results as $result) {
            $this->assertTrue(false !== strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustNotContain()
    {
        $filter = new Filter();
        $filter->mustNot()->contain('name', 'Ken');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(3, count($results));
        foreach ($results as $result) {
            $this->assertFalse(strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustNotNotContain()
    {
        $filter = new Filter();
        $filter->mustNot()->notContain('name', 'Ken');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
        foreach ($results as $result) {
            $this->assertTrue(false !== strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustNotEndsWith()
    {
        $filter = new Filter();
        $filter->mustNot()->endsWith('name', 'mori');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(3, count($results));
        foreach ($results as $result) {
            $this->assertFalse(strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustNotStartsWith()
    {
        $filter = new Filter();
        $filter->mustNot()->startsWith('name', 'Ke');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(3, count($results));
        foreach ($results as $result) {
            $this->assertFalse(strpos($result->name(), 'Ken'));
        }
    }

    public function testFindByWithMustNotBeLessThan()
    {
        $filter = new Filter();
        $filter->mustNot()->beLessThan('totalOrders', 2);

        $results = $this->repository->findBy($filter);

        $this->assertEquals(4, count($results));
    }

    public function testFindByWithMustNotBeLessThanOrEqual()
    {
        $filter = new Filter();
        $filter->mustNot()->beLessThanOrEqual('totalOrders', 4);

        $results = $this->repository->findBy($filter);

        $this->assertEquals(1, count($results));
    }

    public function testFindByWithMustNotBeGreaterThan()
    {
        $filter = new Filter();
        $filter->mustNot()->beGreaterThan('totalOrders', 6);

        $results = $this->repository->findBy($filter);

        $this->assertEquals(4, count($results));
    }

    public function testFindByWithMustNotBeGreaterThanOrEqual()
    {
        $filter = new Filter();
        $filter->mustNot()->beGreaterThanOrEqual('totalOrders', 6);

        $results = $this->repository->findBy($filter);

        $this->assertEquals(4, count($results));
    }

    public function testFindByMustNotIncludeGroup()
    {
        $filter = new Filter();
        $filter->mustNot()->includeGroup(
            'date',
            [new DateTime('2010-12-01'), new DateTime('2010-12-10'), new DateTime('2013-02-22')]
        );

        $results = $this->repository->findBy($filter);

        $this->assertEquals(1, count($results));
    }

    public function testFindByMustNotNotIncludeGroup()
    {
        $filter = new Filter();
        $filter->mustNot()->notIncludeGroup(
            'date',
            [new DateTime('2010-12-01'), new DateTime('2010-12-10'), new DateTime('2013-02-22')]
        );

        $results = $this->repository->findBy($filter);

        $this->assertEquals(3, count($results));
    }

    public function testFindByMustNotRange()
    {
        $filter = new Filter();
        $filter->mustNot()->range('totalOrders', 2, 4);
        $results = $this->repository->findBy($filter);
        $this->assertEquals(1, count($results));
    }

    public function testFindByMustNotNotRangeTest()
    {
        $filter = new Filter();
        $filter->mustNot()->notRange('totalOrders', 2, 4);

        $results = $this->repository->findBy($filter);
        $this->assertEquals(3, count($results));
    }

    //--------------------------------------------------------------------------------
    // SHOULD FILTER TESTS
    //--------------------------------------------------------------------------------

    public function testFindByWithShouldEqual()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->equal('name', 'Ken Sugimori');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
    }

    public function testFindByShouldContain()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->contain('name', 'Ken');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
    }

    public function testFindByShouldNotContainTest()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->notContain('name', 'Ken');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(3, count($results));
    }

    public function testFindByShouldEndsWith()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->endsWith('name', 'mori');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
    }

    public function testFindByShouldStartsWith()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->startsWith('name', 'Ke');

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(1, count($results));
    }

    public function testFindByShouldBeLessThan()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->beLessThan('totalOrders', 6);

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(4, count($results));
    }

    public function testFindByShouldBeLessThanOrEqual()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->beLessThanOrEqual('totalOrders', 4);

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(3, count($results));
    }

    public function testFindByShouldBeGreaterThan()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->beGreaterThan('totalOrders', 2);

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(4, count($results));
    }

    public function testFindByShouldBeGreaterThanOrEqual()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->beGreaterThanOrEqual('totalOrders', 2);

        $fields = new Fields(['name']);
        $results = $this->repository->findBy($filter, null, $fields);

        $this->assertEquals(4, count($results));
    }

    public function testFindByShouldIncludeGroup()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->includeGroup(
            'date',
            [new DateTime('2010-12-01'), new DateTime('2010-12-10'), new DateTime('2013-02-22')]
        );

        $results = $this->repository->findBy($filter);

        $this->assertEquals(3, count($results));
    }

    public function testFindByShouldNotIncludeGroupTest()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->notIncludeGroup(
            'date',
            [new DateTime('2010-12-01'), new DateTime('2010-12-10'), new DateTime('2013-02-22')]
        );

        $results = $this->repository->findBy($filter);


        $this->assertEquals(1, count($results));
    }

    public function testFindByShouldRange()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'Hideo Kojima');
        $filter->should()->range('totalOrders', 2, 4);

        $results = $this->repository->findBy($filter);

        $this->assertEquals(3, count($results));
    }

    public function testFindByShouldNotRangeTest()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'John Doe');
        $filter->should()->notRange('totalOrders', 2, 4);

        $results = $this->repository->findBy($filter);
        $this->assertEquals(2, count($results));
    }

    public function testFindByShouldNotEqualTest()
    {
        $filter = new Filter();
        $filter->must()->contain('name', 'John Doe');
        $filter->should()->notEqual('name', 'Shigeru Miyamoto');

        $results = $this->repository->findBy($filter);

        $this->assertEquals(3, count($results));
    }
}
