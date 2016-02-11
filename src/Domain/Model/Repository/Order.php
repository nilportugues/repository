<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/15/15
 * Time: 11:13 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository;

use InvalidArgumentException;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Order as OrderInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Traits\Nullable;

class Order implements OrderInterface
{
    use Nullable;

    /**
     * @var string
     */
    protected $direction;

    /**
     * @param string $direction
     */
    public function __construct($direction)
    {
        $direction = (string) strtoupper($direction);
        $this->assert($direction);
        $this->direction = $direction;
    }

    /**
     * @param string $direction
     *
     * @throws \InvalidArgumentException
     */
    protected function assert($direction)
    {
        if (false === in_array($direction, [self::ASCENDING, self::DESCENDING], true)) {
            throw new InvalidArgumentException('Only accepted values for direction must be either ASC or DESC');
        }
    }

    /**
     * @return bool
     */
    public function isDescending()
    {
        return !$this->isAscending();
    }

    /**
     * @return bool
     */
    public function isAscending()
    {
        return $this->direction == self::ASCENDING;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->direction;
    }

    /**
     * @param self $object
     *
     * @return bool
     */
    public function equals($object)
    {
        return get_class($this) === get_class($object)
        && $this->direction() === $object->direction();
    }

    /**
     * @return string
     */
    public function direction()
    {
        return (!empty($this->direction)) ? $this->direction : self::ASCENDING;
    }
}
