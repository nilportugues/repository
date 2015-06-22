<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 8:59 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Tests\Foundation\Domain\Repository;

use InvalidArgumentException;
use PhpDdd\Foundation\Domain\Repository\Order;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanBuildDirections()
    {
        $asc = new Order('ASC');
        $desc = new Order('DESC');

        $this->assertEquals('ASC', $asc->getDirection());
        $this->assertTrue($asc->isAscending());

        $this->assertEquals('DESC', $desc->getDirection());
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
}
