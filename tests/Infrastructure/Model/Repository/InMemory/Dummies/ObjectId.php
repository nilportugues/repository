<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 25/01/16
 * Time: 21:05.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;

class ObjectId implements Identity
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->id;
    }
}
