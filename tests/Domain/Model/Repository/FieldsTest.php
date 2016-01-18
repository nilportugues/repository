<?php

namespace NilPortugues\Tests\Foundation\Domain\Model\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Fields;

class FieldsTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanConstruct()
    {
        $fields = new Fields(['first']);
        $fields->add('second');

        $this->assertEquals(['first', 'second'], $fields->get());
    }

    public function testItCanAdd()
    {
        $fields = new Fields();
        $fields->add('first');

        $this->assertEquals(['first'], $fields->get());
    }
}
