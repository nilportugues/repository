<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 22/01/16
 * Time: 20:51.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Tests\Foundation\Infrastructure\Model\Repository\InMemory\Dummies;

/**
 * Class Clients.
 */
class Clients
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var int
     */
    private $totalOrders;

    /**
     * @var \DateTime[]
     */
    private $orderDates = [];

    /**
     * @var float
     */
    private $totalEarnings;

    /**
     * Clients constructor.
     *
     * @param string      $name
     * @param \DateTime   $date
     * @param int         $totalOrders
     * @param \DateTime[] $orderDates
     * @param float       $totalEarnings
     */
    public function __construct($name, \DateTime $date, $totalOrders, array $orderDates, $totalEarnings)
    {
        $this->name = $name;
        $this->date = $date;
        $this->totalOrders = $totalOrders;
        $this->orderDates = $orderDates;
        $this->totalEarnings = $totalEarnings;
    }

    /**
     * Returns value for `name`.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns value for `date`.
     *
     * @return \DateTime
     */
    public function date()
    {
        return $this->date;
    }

    /**
     * Returns value for `totalOrder`.
     *
     * @return int
     */
    public function totalOrders()
    {
        return $this->totalOrders;
    }

    /**
     * Returns value for `orderDates`.
     *
     * @return \DateTime[]
     */
    public function orderDates()
    {
        return $this->orderDates;
    }

    /**
     * Returns value for `totalEarnings`.
     *
     * @return float
     */
    public function totalEarnings()
    {
        return $this->totalEarnings;
    }
}
