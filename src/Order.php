<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/15/15
 * Time: 11:13 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\DDDFoundation\Domain\Repository;

use InvalidArgumentException;

final class Order
{
    const ASCENDING  = 'ASC';
    const DESCENDING = 'DESC';

    /**
     * @var string
     */
    private $direction;

    /**
     * @param string $direction
     */
    public function __construct($direction)
    {
        $direction = (string) strtoupper($direction);
        $this->isValidDirection($direction);
        $this->direction  = $direction;

    }

    /**
     * @param string $direction
     *
     * @throws \InvalidArgumentException
     */
    private function isValidDirection($direction)
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
        return $this->direction === self::ASCENDING;
    }
    /**
     * @return string
     */
    public function getDirection()
    {
        return (!empty($this->direction)) ? $this->direction : self::ASCENDING;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->direction;
    }
}
