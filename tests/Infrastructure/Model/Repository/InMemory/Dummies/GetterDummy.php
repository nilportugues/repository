<?php

namespace NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies;

class GetterDummy
{
    private $value;

    /**
     * GetterDummy constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns value for value property.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
