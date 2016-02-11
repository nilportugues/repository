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
}
