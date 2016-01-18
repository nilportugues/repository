<?php

namespace NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies;

class TellDontAskGetterDummy
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
    public function value()
    {
        return $this->value;
    }
}
