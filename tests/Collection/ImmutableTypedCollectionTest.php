<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/17/15
 * Time: 1:00 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Tests\Foundation\Domain\Repository\Collection;

use DateTime;
use PhpDdd\Foundation\Domain\Repository\Collection\ImmutableTypedCollection;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use stdClass;

class ImmutableTypedCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testItSetsTypedValues()
    {
        $collection = new ImmutableTypedCollection(2);

        $collection[] = 0;
        $collection[] = 1;

        $this->assertEquals(0, $collection[0]);
        $this->assertEquals(1, $collection[1]);
    }

    public function testItThrowsExceptionWhenDifferentTypesAreSet()
    {
        $collection = new ImmutableTypedCollection(2);

        $collection[] = 0;

        $this->setExpectedException(RuntimeException::class);
        $collection[] = 'a';
    }

    public function testItThrowsExceptionWhenDifferentClassesAreSet()
    {
        $collection = new ImmutableTypedCollection(2);

        $collection[] = new stdClass();

        $this->setExpectedException(RuntimeException::class);
        $collection[] = new DateTime('now');
    }

    public function testIsJsonSerializable()
    {
        $data = [0, 1];

        $collection = new ImmutableTypedCollection(2);
        $collection[] = 0;
        $collection[] = 1;

        $this->assertEquals(json_encode($data), json_encode($collection));
    }
}
