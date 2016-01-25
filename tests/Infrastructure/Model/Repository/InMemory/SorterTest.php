<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 15/01/16
 * Time: 19:39.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory;

use Exception;
use NilPortugues\Foundation\Domain\Model\Repository\Order;
use NilPortugues\Foundation\Domain\Model\Repository\Sort;
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\Sorter;
use NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies\EmptyDummy;
use NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies\GetterDummy;
use NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies\PublicPropertyDummy;
use NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies\TellDontAskGetterDummy;
use stdClass;

class SorterTest extends \PHPUnit_Framework_TestCase
{
    public function testSortWillThrowExceptionIfPropertyDoesNotExist()
    {
        $results = [new EmptyDummy(), new EmptyDummy()];
        $sort = new Sort(['property1'], new Order('ASC'));

        $this->setExpectedException(Exception::class);
        Sorter::sort($results, $sort);
    }

    public function testSortFetchValueUsingGetterMethod()
    {
        $object1 = new GetterDummy(1);
        $object2 = new GetterDummy(2);

        $results = [$object2, $object1];
        $sort = new Sort(['value'], new Order('ASC'));

        Sorter::sort($results, $sort);
        $output = Sorter::sort($results, $sort);

        $expected = [$object1, $object2];
        $this->assertEquals($expected, $output);
    }

    public function testSortFetchValueUsingPublicPropertyMethod()
    {
        $object1 = new PublicPropertyDummy(1);
        $object2 = new PublicPropertyDummy(2);

        $results = [$object2, $object1];
        $sort = new Sort(['value'], new Order('ASC'));

        Sorter::sort($results, $sort);
        $output = Sorter::sort($results, $sort);

        $expected = [$object1, $object2];
        $this->assertEquals($expected, $output);
    }

    public function testSortFetchValueUsingTellDontAskGetterMethod()
    {
        $object1 = new TellDontAskGetterDummy(1);
        $object2 = new TellDontAskGetterDummy(2);

        $results = [$object2, $object1];
        $sort = new Sort(['value'], new Order('ASC'));

        Sorter::sort($results, $sort);
        $output = Sorter::sort($results, $sort);

        $expected = [$object1, $object2];
        $this->assertEquals($expected, $output);
    }

    public function testAscendingSort()
    {
        $object1 = new stdClass();
        $object1->name = 'Name1';

        $object2 = new stdClass();
        $object2->name = 'Name2';

        $object3 = new stdClass();
        $object3->name = 'Name3';

        $object4 = new stdClass();
        $object4->name = 'Name4';

        $object5 = new stdClass();
        $object5->name = 'Name5';

        $results = [$object5, $object3, $object1, $object4, $object2];
        $sort = new Sort(['name'], new Order('ASC'));

        $output = Sorter::sort($results, $sort);

        $expected = [$object1, $object2, $object3, $object4, $object5];

        $this->assertEquals($expected, $output);
    }

    public function testDescendingSort()
    {
        $object1 = new stdClass();
        $object1->name = 'Name1';

        $object2 = new stdClass();
        $object2->name = 'Name2';

        $object3 = new stdClass();
        $object3->name = 'Name3';

        $object4 = new stdClass();
        $object4->name = 'Name4';

        $object5 = new stdClass();
        $object5->name = 'Name5';

        $results = [$object5, $object3, $object1, $object4, $object2];
        $sort = new Sort(['name'], new Order('DESC'));

        $results = Sorter::sort($results, $sort);

        $expected = [$object5, $object4, $object3, $object2, $object1];

        $this->assertEquals($expected, $results);
    }
}
