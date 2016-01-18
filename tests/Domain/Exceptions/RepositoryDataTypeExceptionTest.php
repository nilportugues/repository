<?php

namespace NilPortugues\Tests\Foundation\Domain\Model\Repository\Exceptions;

use NilPortugues\Foundation\Domain\Model\Repository\Exceptions\RepositoryDataTypeException;

class RepositoryDataTypeExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $this->setExpectedException(
            RepositoryDataTypeException::class,
            "Expected variable of type 'stdClass', but got a variable of type 'string' instead."
        );

        throw new RepositoryDataTypeException('stdClass', $variable = 'Hello');
    }
}
