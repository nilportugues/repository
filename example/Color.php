<?php

namespace NilPortugues\Example\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;

class Color implements Identity
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $hexCode;

    /**
     * Color constructor.
     * @param string $name
     * @param string $hexCode
     */
    public function __construct($name, $hexCode)
    {
        $this->name = $name;
        $this->hexCode = $hexCode;
    }

    /**
     * Returns value for name property.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns value for hexCode property.
     *
     * @return string
     */
    public function getHexCode()
    {
        return $this->hexCode;
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->getHexCode();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getHexCode();
    }
}