<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 8:59 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Tests\Foundation\Domain\Model\Repository;

use InvalidArgumentException;
use NilPortugues\Foundation\Domain\Model\Repository\Order;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanBuildDirections()
    {
        $asc = new Order('ASC');
        $desc = new Order('DESC');

        $this->assertEquals('ASC', $asc->direction());
        $this->assertTrue($asc->isAscending());

        $this->assertEquals('DESC', $desc->direction());
        $this->assertTrue($desc->isDescending());
    }

    public function testItCanCastToString()
    {
        $order = new Order('ASC');
        $this->assertEquals('ASC', (string) $order);
    }

    public function testItWillThrowExceptionOnInvalidDirection()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new Order('RANDOM');
    }

    public function testItCanEqual()
    {
        $order = new Order('ASC');
        $this->assertTrue($order->equals(new Order('ASC')));
    }
}
