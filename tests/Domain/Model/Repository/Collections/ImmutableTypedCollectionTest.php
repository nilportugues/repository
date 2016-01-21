<?php

namespace NilPortugues\Tests\Foundation\Domain\Model\Repository\Collections;

use DateTime;
use NilPortugues\Foundation\Domain\Model\Repository\Collections\ImmutableTypedCollection;
use RuntimeException;
use stdClass;

class ImmutableTypedCollectionTest extends \PHPUnit_Framework_TestCase
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
}
