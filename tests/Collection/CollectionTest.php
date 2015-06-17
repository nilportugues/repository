<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/17/15
 * Time: 1:46 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Tests\Foundation\Domain\Repository\Collection;

use PhpDdd\Foundation\Domain\Repository\Collection\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testItHasKey()
    {
        $collection = new Collection();
        $collection[] = 2;

        $this->assertTrue(empty($collection['a']));
        $this->assertFalse(empty($collection[0]));

        unset($collection[0]);
        $this->assertTrue(empty($collection[0]));
    }

    public function testItCanCount()
    {
        $collection = new Collection([2]);

        $this->assertEquals(1, count($collection));
    }

    public function testToArray()
    {
        $collection = new Collection();
        $collection[] = 2;

        $this->assertEquals([2], $collection->toArray());
    }

    public function testJsonEncode()
    {
        $collection = new Collection();
        $collection[] = 2;

        $this->assertEquals(json_encode([2]), json_encode($collection));
    }

    public function testArrayIterator()
    {
        $collection = new Collection([1,2,3,4,5]);

        foreach ($collection as $key => $value) {
            $this->assertEquals($key+1, $value);
        }
    }
}
