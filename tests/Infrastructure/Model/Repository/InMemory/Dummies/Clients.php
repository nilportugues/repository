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

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;

/**
 * Class Clients.
 */
class Clients implements Identity
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
     * @var string
     */
    private $id;

    /**
     * Clients constructor.
     *
     * @param           $id
     * @param           $name
     * @param \DateTime $date
     * @param           $totalOrders
     * @param array     $orderDates
     * @param           $totalEarnings
     */
    public function __construct($id, $name, \DateTime $date, $totalOrders, array $orderDates, $totalEarnings)
    {
        $this->id = $id;
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
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Returns value for `date`.
     *
     * @return \DateTime
     */
    public function date(): \DateTime
    {
        return $this->date;
    }

    /**
     * Returns value for `totalOrder`.
     *
     * @return int
     */
    public function totalOrders(): int
    {
        return $this->totalOrders;
    }

    /**
     * Returns value for `orderDates`.
     *
     * @return \DateTime[]
     */
    public function orderDates(): array
    {
        return $this->orderDates;
    }

    /**
     * Returns value for `totalEarnings`.
     *
     * @return float
     */
    public function totalEarnings(): float
    {
        return $this->totalEarnings;
    }

    public function id()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id();
    }
}
